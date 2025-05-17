// Password visibility toggle and validation
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const togglePassword = document.getElementById('togglePassword');
const requirements = {
  length: document.getElementById('req-length'),
  upper: document.getElementById('req-upper'),
  lower: document.getElementById('req-lower'),
  number: document.getElementById('req-number')
};
const matchMsg = document.getElementById('matchMsg');

togglePassword.addEventListener('click', () => {
  password.type = password.type === 'password' ? 'text' : 'password';
  togglePassword.querySelector('i').classList.toggle('fa-eye');
  togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
});

function updateReq(el, valid) {
  el.classList.toggle('valid', valid);
  el.classList.toggle('invalid', !valid);
}

password.addEventListener('input', () => {
  const val = password.value;
  updateReq(requirements.length, val.length >= 8);
  updateReq(requirements.upper, /[A-Z]/.test(val));
  updateReq(requirements.lower, /[a-z]/.test(val));
  updateReq(requirements.number, /[0-9]/.test(val));
  checkMatch();
});

confirmPassword.addEventListener('input', checkMatch);

function checkMatch() {
  if (confirmPassword.value === '') return matchMsg.textContent = '';
  const match = password.value === confirmPassword.value;
  matchMsg.textContent = match ? "✓ Les mots de passe correspondent" : "❌ Les mots de passe ne correspondent pas";
  matchMsg.className = match ? "form-text text-success" : "form-text text-danger";
}

document.getElementById('signupForm').addEventListener('submit', (e) => {
  e.preventDefault(); // Prevent form submission
  if (password.value !== confirmPassword.value) return alert("Les mots de passe ne correspondent pas.");
  if (!document.getElementById('agreeTerms').checked) return alert("Veuillez accepter les conditions.");
  window.location.href = 'login.html'; // Redirect to the main page after login
});