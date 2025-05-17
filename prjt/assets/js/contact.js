// Simple form submission
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    
    // Show success message
    alert(`Merci ${firstName} ${lastName} ! Votre message a été envoyé avec succès. Nous vous contacterons prochainement à l'adresse ${email}.`);
    
    // Reset form
    this.reset();
});