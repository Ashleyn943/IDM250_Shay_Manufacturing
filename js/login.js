    function handleLogin(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const messageDiv = document.getElementById('loginMessage');
        
        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.className = 'message success';
                messageDiv.textContent = 'Login successful! Redirecting...';
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                messageDiv.className = 'message error';
                messageDiv.textContent = data.error;
            }
        })
        .catch(error => {
            messageDiv.className = 'message error';
            messageDiv.textContent = 'An error occurred. Please try again.';
            console.error('Error:', error);
        });
    }