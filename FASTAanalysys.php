<!DOCTYPE html>
<html>
<head>
    <title>FASTA Analysis</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
        <nav>
            <ul>
                <li>FASTA File Analysis site</li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
</header>
    <h2>Upload FASTA File for Analysis</h2>
    <form action="FASTAanalysis.php" method="post" enctype="multipart/form-data">
        <label for="file">Select FASTA file:</label><br>
        <input type="file" id="file" name="file" accept=".fasta" required><br><br>
        <input type="submit" name="submit" value="Upload and Analyze">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES['file'])) {
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];

            // Validate the file
            $allowed_ext = "fasta";
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            if ($file_ext !== $allowed_ext) {
                echo "Invalid file type. Please upload a FASTA file.";
            } else {
                // Move the uploaded file to a directory
                $upload_dir = "uploads/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $uploaded_file = $upload_dir . basename($file_name);
                if (move_uploaded_file($file_tmp, $uploaded_file)) {
                    echo "File uploaded successfully.<br>";

                    // Parse and analyze the FASTA file
                    $sequences = file($uploaded_file);
                    $total_length = 0;
                    $gc_count = 0;
                    foreach ($sequences as $line) {
                        if ($line[0] != '>') {
                            $seq = trim($line);
                            $total_length += strlen($seq);
                            $gc_count += substr_count($seq, 'G') + substr_count($seq, 'C');
                        }
                    }
                    if ($total_length > 0) {
                        $gc_content = ($gc_count / $total_length) * 100;
                        echo "Total Sequence Length: " . $total_length . " bases<br>";
                        echo "GC Content: " . round($gc_content, 2) . "%<br>";
                    } else {
                        echo "No valid sequences found in the uploaded FASTA file.";
                    }
                } else {
                    echo "Failed to upload file.";
                }
            }
        } else {
            echo "No file uploaded.";
        }
    }
    ?>
</body>
</html>

