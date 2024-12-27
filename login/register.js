document.getElementById('submitButton').addEventListener('click', async () => {
    const form = document.getElementById('registrationForm');
    const formData = new FormData(form);

    const messageDiv = document.getElementById('message');

    if(formData.get('password') !== formData.get('confirm_password')){
        messageDiv.innerHTML = 'Passwords do not match';
        messageDiv.style.color = 'red';
        return;
    }

    const payload = {
        username: formData.get('username'),
        email: formData.get('email'),
        password: formData.get('password'),
        confirm_password: formData.get('confirm_password')
    };

    try {
        const response = await fetch('signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
    
        const result = await response.json();
        messageDiv.innerHTML = result.message;
        messageDiv.style.color = result.success ? 'green' : 'red';
    
        if (result.success) {
            setTimeout(() => {
                window.location.reload(); // Reload or redirect as needed
            }, 2000);
        }
    } catch (error) {
        console.error('Error:', error);
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = 'An unexpected error occurred. Please try again.';
        messageDiv.style.color = 'red';
    }
});
