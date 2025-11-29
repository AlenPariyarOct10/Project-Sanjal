// Nepal IT Project Hub - Authentication Module

// Toast notification function
function showToast(message, type = "success") {
  const container = document.querySelector(".toast-container") || createToastContainer()
  const toast = document.createElement("div")
  toast.className = `toast ${type}`
  toast.textContent = message
  container.appendChild(toast)

  setTimeout(() => {
    toast.style.animation = "fadeOut 0.3s ease"
    setTimeout(() => toast.remove(), 300)
  }, 3000)
}

// Create toast container if it doesn't exist
function createToastContainer() {
  const container = document.createElement("div")
  container.className = "toast-container"
  document.body.appendChild(container)
  return container
}

// Show alert message in form
function showAlert(message, type = "info") {
  const alertContainer = document.getElementById("alertContainer")
  if (!alertContainer) return

  const alert = document.createElement("div")
  alert.className = `alert alert-${type}`
  alert.innerHTML = `
    <span class="alert-icon">${getAlertIcon(type)}</span>
    <span>${message}</span>
  `

  alertContainer.innerHTML = ""
  alertContainer.appendChild(alert)

  if (type === "error" || type === "success") {
    setTimeout(() => {
      alert.style.animation = "fadeOut 0.3s ease"
      setTimeout(() => alert.remove(), 300)
    }, 4000)
  }
}

// Get alert icon based on type
function getAlertIcon(type) {
  const icons = {
    success: "✓",
    error: "✕",
    warning: "!",
    info: "ℹ",
  }
  return icons[type] || "ℹ"
}

// Form Validation
function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return regex.test(email)
}

function validatePassword(password) {
  // Min 8 chars, 1 uppercase, 1 number, 1 special char
  const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
  return regex.test(password)
}

// Password Strength Checker
function checkPasswordStrength(event) {
  const password = event.target.value
  const strengthBar = document.getElementById("strengthBar")
  const strengthText = document.getElementById("strengthText")

  if (!strengthBar || !strengthText) return

  let strength = 0
  let strengthLevel = "weak"

  // Check length
  if (password.length >= 8) strength++
  if (password.length >= 12) strength++

  // Check for uppercase
  if (/[A-Z]/.test(password)) strength++

  // Check for lowercase
  if (/[a-z]/.test(password)) strength++

  // Check for numbers
  if (/\d/.test(password)) strength++

  // Check for special characters
  if (/[@$!%*?&]/.test(password)) strength++

  // Determine strength level
  if (strength < 2) {
    strengthLevel = "weak"
  } else if (strength < 4) {
    strengthLevel = "medium"
  } else {
    strengthLevel = "strong"
  }

  // Update strength bar
  strengthBar.className = `password-strength-bar ${strengthLevel}`

  // Update strength text
  const strengthTexts = {
    weak: "Weak password. Add uppercase, numbers, and special characters.",
    medium: "Medium password. Consider adding more variety.",
    strong: "Strong password! Ready to register.",
  }

  strengthText.textContent = strengthTexts[strengthLevel]
  strengthText.style.color = strengthLevel === "weak" ? "#dc3545" : strengthLevel === "medium" ? "#ffc107" : "#28a745"
}

// Login Handler
function handleLogin(event) {
  event.preventDefault()

  const email = document.getElementById("email").value.trim()
  const password = document.getElementById("password").value.trim()
  const rememberMe = document.querySelector('input[name="remember"]').checked

  // Validation
  if (!email || !password) {
    showAlert("Please fill in all fields", "error")
    return
  }

  if (!validateEmail(email)) {
    showAlert("Please enter a valid email address", "error")
    return
  }

  if (password.length < 6) {
    showAlert("Password must be at least 6 characters", "error")
    return
  }

  // Simulate API call
  const button = event.target.querySelector("button[type='submit']")
  button.classList.add("loading")
  button.disabled = true

  setTimeout(() => {
    // Check against stored users (in real app, this would be an API call)
    const users = JSON.parse(localStorage.getItem("users") || "[]")
    const user = users.find((u) => u.email === email && u.password === password)

    button.classList.remove("loading")
    button.disabled = false

    if (user) {
      // Store session
      const sessionData = {
        id: user.id,
        name: user.name,
        email: user.email,
        university: user.university,
        college: user.college,
        loginTime: new Date().toISOString(),
      }

      localStorage.setItem("currentUser", JSON.stringify(sessionData))
      if (rememberMe) {
        localStorage.setItem("rememberEmail", email)
      }

      showAlert("Login successful! Redirecting...", "success")
      setTimeout(() => {
        window.location.href = "index.html"
      }, 1500)
    } else {
      showAlert("Invalid email or password", "error")
    }
  }, 1500)
}

// Register Handler
function handleRegister(event) {
  event.preventDefault()

  const firstName = document.getElementById("firstName").value.trim()
  const lastName = document.getElementById("lastName").value.trim()
  const email = document.getElementById("email").value.trim()
  const university = document.getElementById("university").value
  const college = document.getElementById("college").value.trim()
  const password = document.getElementById("password").value
  const confirmPassword = document.getElementById("confirmPassword").value
  const termsAccepted = document.querySelector('input[name="terms"]').checked

  // Validation
  if (!firstName || !lastName || !email || !university || !college || !password || !confirmPassword) {
    showAlert("Please fill in all fields", "error")
    return
  }

  if (!validateEmail(email)) {
    showAlert("Please enter a valid email address", "error")
    return
  }

  if (!validatePassword(password)) {
    showAlert(
      "Password must contain at least 8 characters, 1 uppercase letter, 1 number, and 1 special character",
      "error",
    )
    return
  }

  if (password !== confirmPassword) {
    showAlert("Passwords do not match", "error")
    return
  }

  if (!termsAccepted) {
    showAlert("You must accept the Terms of Service", "error")
    return
  }

  // Check if email already exists
  const users = JSON.parse(localStorage.getItem("users") || "[]")
  if (users.some((u) => u.email === email)) {
    showAlert("Email already registered. Please login or use a different email", "error")
    return
  }

  // Simulate API call
  const button = event.target.querySelector("button[type='submit']")
  button.classList.add("loading")
  button.disabled = true

  setTimeout(() => {
    // Create new user
    const newUser = {
      id: Date.now(),
      firstName,
      lastName,
      name: `${firstName} ${lastName}`,
      email,
      university,
      college,
      password, // In real app, this should be hashed
      registeredDate: new Date().toISOString(),
      projects: [],
    }

    users.push(newUser)
    localStorage.setItem("users", JSON.stringify(users))

    button.classList.remove("loading")
    button.disabled = false

    showAlert("Account created successfully! Redirecting to login...", "success")
    setTimeout(() => {
      window.location.href = "login.html"
    }, 1500)
  }, 1500)
}

// Password Recovery Handler
function handlePasswordRecovery(event) {
  event.preventDefault()

  const email = document.getElementById("email").value.trim()

  // Validation
  if (!email) {
    showAlert("Please enter your email address", "error")
    return
  }

  if (!validateEmail(email)) {
    showAlert("Please enter a valid email address", "error")
    return
  }

  // Simulate API call
  const button = event.target.querySelector("button[type='submit']")
  button.classList.add("loading")
  button.disabled = true

  setTimeout(() => {
    // Check if user exists
    const users = JSON.parse(localStorage.getItem("users") || "[]")
    const userExists = users.some((u) => u.email === email)

    button.classList.remove("loading")
    button.disabled = false

    if (userExists) {
      // In real app, send email with reset link
      showAlert(
        "Recovery email sent! Check your inbox for password reset instructions (expires in 24 hours)",
        "success",
      )

      // Store recovery request
      const recoveryData = {
        email,
        token: Math.random().toString(36).substr(2, 9),
        timestamp: new Date().toISOString(),
        expiresAt: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString(),
      }
      localStorage.setItem(`recovery_${email}`, JSON.stringify(recoveryData))

      setTimeout(() => {
        window.location.href = "login.html"
      }, 3000)
    } else {
      // For security, don't reveal if email exists
      showAlert("If an account exists with this email, you will receive a recovery link", "success")
      setTimeout(() => {
        window.location.href = "login.html"
      }, 3000)
    }
  }, 1500)
}

// Social Auth Handlers
function socialLogin(provider) {
  showToast(`Logging in with ${provider}...`, "info")
  console.log(`[v0] Social login initiated with ${provider}`)
  // In real app, integrate with OAuth
  setTimeout(() => {
    showToast(`${provider} login not configured yet`, "error")
  }, 2000)
}

function socialSignUp(provider) {
  showToast(`Signing up with ${provider}...`, "info")
  console.log(`[v0] Social signup initiated with ${provider}`)
  // In real app, integrate with OAuth
  setTimeout(() => {
    showToast(`${provider} signup not configured yet`, "error")
  }, 2000)
}

// Session Management
function getCurrentUser() {
  const currentUser = localStorage.getItem("currentUser")
  return currentUser ? JSON.parse(currentUser) : null
}

function logoutUser() {
  localStorage.removeItem("currentUser")
  localStorage.removeItem("rememberEmail")
  showToast("Logged out successfully", "success")
  setTimeout(() => {
    window.location.href = "login.html"
  }, 1000)
}

// Check if user is logged in
function checkAuth() {
  const currentUser = getCurrentUser()
  if (!currentUser) {
    window.location.href = "login.html"
  }
  return currentUser
}

// Initialize auth module
document.addEventListener("DOMContentLoaded", () => {
  // Pre-fill remember me email if available
  const rememberEmail = localStorage.getItem("rememberEmail")
  const emailInput = document.getElementById("email")
  if (emailInput && rememberEmail) {
    emailInput.value = rememberEmail
    const rememberCheckbox = document.querySelector('input[name="remember"]')
    if (rememberCheckbox) {
      rememberCheckbox.checked = true
    }
  }
})
