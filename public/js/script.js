document.addEventListener("DOMContentLoaded", function () {
  const logoTypographyContainer = document.querySelector(
    ".logo-typography-container"
  );
  const welcomeText = document.querySelector(".welcome-text");
  const buttonContainer = document.querySelector(".button-container");

  // Step 1: Fade in logo and typography
  setTimeout(() => {
    logoTypographyContainer.style.opacity = "1";
  }, 1000); // 2-second delay

  // Step 2: Slide logo and typography up and position them beside each other
  setTimeout(() => {
    logoTypographyContainer.classList.add("moved-top");
    welcomeText.classList.remove("d-none");
    setTimeout(() => {
      welcomeText.style.opacity = "1"; // Smooth fade for welcome text
    }, 500);
  }, 1500); // 2 seconds after initial fade

  // Step 3: Show buttons with fade-in effect
  setTimeout(() => {
    buttonContainer.classList.remove("d-none");
    buttonContainer.style.opacity = "1";
  }, 3000); // 1 second after welcome text appears

  const signInForm = document.getElementById("signInForm");

  const signUpForm = document.getElementById("signUpForm");
  const codeContainer = document.getElementById("code-container");
  const signInBtn = document.getElementById("signInBtn");
  const signUpBtn = document.getElementById("signUpBtn");
  const sendVerificationCodeButton = document.getElementById("sendVerificationCode");
  const submitSignupButton = document.getElementById("submitSignup");
  const verifyCodeButton = document.getElementById("verifyCode");

  const signInpBtn = document.getElementById("signwithpassword");
  const signInpLink = document.getElementById("signInpBtn");
  const signInpForm = document.getElementById("signInwithpasswordForm");
  // Toggle forms with animation
  signUpBtn.addEventListener("click", () => {
      signInForm.classList.add("d-none");
      codeContainer.classList.add("d-none");
      signInBtn.classList.remove("d-none");
      signUpBtn.classList.add("d-none");
      signUpForm.classList.remove("d-none");
      signInpForm.classList.add("d-none");
      signInpLink.classList.remove("d-none")
  });

  signInBtn.addEventListener("click", () => {
      signUpForm.classList.add("d-none");
      codeContainer.classList.add("d-none");
      signUpBtn.classList.remove("d-none");
      signInBtn.classList.add("d-none");
      signInForm.classList.remove("d-none");
      signInpForm.classList.add("d-none");
      signInpLink.classList.remove("d-none")
  });

  signInpLink.addEventListener("click", () => {
      signUpForm.classList.add("d-none");
      codeContainer.classList.add("d-none");
      signUpBtn.classList.remove("d-none");
      signInBtn.classList.remove("d-none");
      signInForm.classList.add("d-none");
      signInpLink.classList.add("d-none");
      signInpForm.classList.remove("d-none");
  });

  signInpBtn.addEventListener("click", () => {
    console.log("Sign-In Button Clicked");

    const email = document.getElementById("email1").value;
    const password = document.getElementById("password").value;
    const remember = document.getElementById("remember").value;
   // id="remember"// Check if the email is being fetched correctly
    console.log("Email Entered:", email);

    // Proceed with the AJAX request
    fetch('/login-with-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ email, password,remember }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Debug the response
        if (data.success) {
            if (data.message === 'Already logged in.') {
                window.location.href = 'https://sandybrown-fly-224044.hostingersite.com/public/dashboard';
            } else {
                alert('User Name and Password is incorrect.');
               // codeContainer.classList.remove("d-none");
               // signInForm.classList.add("d-none");
               // codeContainer.classList.add("d-block");
                //document.getElementById('emailVerificationForm').style.display = 'none';
                //document.getElementById('verifyCodeForm').style.display = 'block';
            }
        } else {
            alert(data.message);
        }

    })
    .catch(error => console.error('Error:', error));
});

sendVerificationCodeButton.addEventListener("click", () => {
    console.log("Sign-In Button Clicked");

    const email = document.getElementById("email").value;
    const remember = document.getElementById("remember").value;
    // Check if the email is being fetched correctly
    console.log("Email Entered:", email);

    // Proceed with the AJAX request
    fetch('/send-verification-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ email,remember }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Debug the response
        if (data.success) {
            if (data.message === 'Already logged in.') {
                window.location.href = 'https://sandybrown-fly-224044.hostingersite.com/public/dashboard';
            } else {
                alert('Verification code sent to your email.');
                codeContainer.classList.remove("d-none");
                signInForm.classList.add("d-none");
                codeContainer.classList.add("d-block");
                //document.getElementById('emailVerificationForm').style.display = 'none';
                //document.getElementById('verifyCodeForm').style.display = 'block';
            }
        } else {
            alert(data.message);
        }

    })
    .catch(error => console.error('Error:', error));
});

  // Handle signup with AJAX
  submitSignupButton.addEventListener("click", () => {
      const firstName = document.getElementById("firstName").value;
      const lastName = document.getElementById("lastName").value;
      const country = document.getElementById("country").value;
      const city = document.getElementById("city").value;
      const phone = document.getElementById("phone").value;
      const password = document.getElementById("passwordSignup").value;
      const email = document.getElementById("emailSignup").value;
      const address = document.getElementById("address").value;
      const company = document.getElementById("company").value;
      const warehouse = document.getElementById("warehouse").value;
      fetch('/signup', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ firstName, lastName, country, city, phone,password,email,address,warehouse,company }),
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Signup successful. Verification code sent to your email.');
              signUpForm.classList.add("d-none");
              codeContainer.classList.remove("d-none");
          } else {
              alert(data.message);
          }
      })
      .catch(error => console.error('Error:', error));
  });

  // Handle email verification
  verifyCodeButton.addEventListener("click", () => {
      const email = document.getElementById("email").value || document.getElementById("emailSignup").value;
      const verificationCode = document.getElementById("verificationCode").value;

      fetch('/verify-code', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ email, verificationCode }),
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Successfully logged in.');
              window.location.href = 'https://sandybrown-fly-224044.hostingersite.com/public/dashboard';
          } else {
              alert(data.message);
          }
      })
      .catch(error => console.error('Error:', error));
  });
});
