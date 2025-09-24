// frontend/js/form-validation.js

// Validación de correo con '@' (opcionalmente exigir exactamente un '@')
function isEmailWithAt(email) {
    if (!email) return false;
    const atIndex = email.indexOf('@');
    const lastAtIndex = email.lastIndexOf('@');
    if (atIndex <= 0) return false;
    if (atIndex === email.length - 1) return false;
    // Si quieres exigir exactamente un '@':
    // if (lastAtIndex !== atIndex) return false;
    return true;
  }
  
  function setupRegistrationValidation() {
    const regForm = document.querySelector('#registro-form') || document.querySelector('form');
    if (!regForm) return;
  
    regForm.addEventListener('submit', function(e){
      const email = document.getElementById('reg-email').value.trim();
      if (!isEmailWithAt(email)) {
        e.preventDefault();
        alert('Por favor ingresa un correo válido que contenga "@" en una posición adecuada (por ejemplo: usuario@dominio.com).');
        return;
      }
  
      const p1 = document.getElementById('reg-password').value;
      const p2 = document.getElementById('reg-password2').value;
      if (p1 && p2 && p1 !== p2) {
        e.preventDefault();
        alert('Las contraseñas no coinciden. Por favor, verifica.');
      }
    });
  }
  
  function setupLoginValidation() {
    // Aquí puedes añadir validaciones específicas para login si se desean
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    setupRegistrationValidation();
    setupLoginValidation();
  });