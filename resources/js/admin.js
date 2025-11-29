// Admin Dashboard JavaScript Module

// Show toast function declaration
function showToast(message, type) {
  const toast = document.createElement("div")
  toast.className = `toast ${type}`
  toast.textContent = message
  document.body.appendChild(toast)

  setTimeout(() => {
    document.body.removeChild(toast)
  }, 3000)
}


// Users Management
function loadUsers() {
  const tbody = document.getElementById("usersTableBody")
  if (!tbody) return

  tbody.innerHTML = adminData.users
    .map(
      (user) => `
    <tr>
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.role}</td>
      <td>${user.college}</td>
      <td>${new Date(user.joined).toLocaleDateString()}</td>
      <td>
        <span class="status-badge ${user.status === "active" ? "active" : "inactive"}">
          ${user.status}
        </span>
      </td>
      <td>
        <div class="action-buttons">
          <button class="btn-icon" onclick="editUser(${user.id})">Edit</button>
          <button class="btn-icon btn-delete" onclick="deleteUser(${user.id})">Delete</button>
        </div>
      </td>
    </tr>
  `,
    )
    .join("")
}

function editUser(id) {
  const user = adminData.users.find((u) => u.id === id)
  if (user) {
    document.getElementById("userName").value = user.name
    document.getElementById("userEmail").value = user.email
    document.getElementById("userRole").value = user.role
    document.getElementById("userCollege").value = user.college
    document.getElementById("userModal").classList.add("active")
  }
}

function deleteUser(id) {
  if (confirm("Are you sure you want to delete this user?")) {
    adminData.users = adminData.users.filter((u) => u.id !== id)
    loadUsers()
    showToast("User deleted successfully", "success")
  }
}

function handleUserSubmit(event) {
  event.preventDefault()
  const name = document.getElementById("userName").value
  const email = document.getElementById("userEmail").value
  const role = document.getElementById("userRole").value
  const college = document.getElementById("userCollege").value

  const newUser = {
    id: Math.max(...adminData.users.map((u) => u.id), 0) + 1,
    name,
    email,
    role,
    college,
    joined: new Date().toISOString().split("T")[0],
    status: "active",
  }

  adminData.users.push(newUser)
  loadUsers()
  closeUserModal()
  showToast("User added successfully", "success")
}

function closeUserModal() {
  document.getElementById("userModal").classList.remove("active")
  document.getElementById("userForm").reset()
}

function populateCollegeDropdown() {
  const select = document.getElementById("userCollege")
  if (select) {
    select.innerHTML =
      '<option value="">Select College</option>' +
      adminData.colleges.map((c) => `<option value="${c.name}">${c.name}</option>`).join("")
  }
}

// Algorithms Management
function loadAlgorithms() {
  const container = document.getElementById("algorithmsGrid")
  if (!container) return

  container.innerHTML = adminData.algorithms
    .map(
      (algo) => `
    <div class="algorithm-card">
      <h4>${algo.name}</h4>
      <div class="algorithm-meta">
        <span><strong>Category:</strong> ${algo.category}</span>
      </div>
      <p class="algorithm-description">${algo.description}</p>
      <div class="algorithm-complexity">${algo.complexity}</div>
      <div class="action-buttons">
        <button class="btn-icon" onclick="editAlgorithm(${algo.id})">Edit</button>
        <button class="btn-icon btn-delete" onclick="deleteAlgorithm(${algo.id})">Delete</button>
      </div>
    </div>
  `,
    )
    .join("")
}

function editAlgorithm(id) {
  const algo = adminData.algorithms.find((a) => a.id === id)
  if (algo) {
    document.getElementById("algorithmName").value = algo.name
    document.getElementById("algorithmCategory").value = algo.category
    document.getElementById("algorithmDescription").value = algo.description
    document.getElementById("algorithmComplexity").value = algo.complexity
    document.getElementById("algorithmModal").classList.add("active")
  }
}

function deleteAlgorithm(id) {
  if (confirm("Are you sure you want to delete this algorithm?")) {
    adminData.algorithms = adminData.algorithms.filter((a) => a.id !== id)
    loadAlgorithms()
    showToast("Algorithm deleted successfully", "success")
  }
}

function handleAlgorithmSubmit(event) {
  event.preventDefault()
  const name = document.getElementById("algorithmName").value
  const category = document.getElementById("algorithmCategory").value
  const description = document.getElementById("algorithmDescription").value
  const complexity = document.getElementById("algorithmComplexity").value

  const newAlgorithm = {
    id: Math.max(...adminData.algorithms.map((a) => a.id), 0) + 1,
    name,
    category,
    description,
    complexity,
  }

  adminData.algorithms.push(newAlgorithm)
  loadAlgorithms()
  closeAlgorithmModal()
  showToast("Algorithm added successfully", "success")
}

function closeAlgorithmModal() {
  document.getElementById("algorithmModal").classList.remove("active")
  document.getElementById("algorithmForm").reset()
}

// Universities & Colleges Management
function loadUniversities() {
  const container = document.getElementById("universitiesGrid")
  if (!container) return

  container.innerHTML = adminData.universities
    .map(
      (uni) => `
    <div class="institution-card">
      <h4>${uni.name}</h4>
      <div class="institution-info">
        <strong>Location:</strong> ${uni.location}
      </div>
      <div class="institution-info">
        <strong>Colleges:</strong> ${uni.colleges}
      </div>
      <div class="action-buttons">
        <button class="btn-icon" onclick="editUniversity(${uni.id})">Edit</button>
        <button class="btn-icon btn-delete" onclick="deleteUniversity(${uni.id})">Delete</button>
      </div>
    </div>
  `,
    )
    .join("")

  const filterSelect = document.getElementById("filterUniversity")
  if (filterSelect) {
    filterSelect.innerHTML =
      '<option value="">All Universities</option>' +
      adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
  }
}

function editUniversity(id) {
  const uni = adminData.universities.find((u) => u.id === id)
  if (uni) {
    document.getElementById("universityName").value = uni.name
    document.getElementById("universityLocation").value = uni.location
    document.getElementById("universityModal").classList.add("active")
  }
}

function deleteUniversity(id) {
  if (confirm("Are you sure you want to delete this university?")) {
    adminData.universities = adminData.universities.filter((u) => u.id !== id)
    loadUniversities()
    showToast("University deleted successfully", "success")
  }
}

function handleUniversitySubmit(event) {
  event.preventDefault()
  const name = document.getElementById("universityName").value
  const location = document.getElementById("universityLocation").value

  const newUniversity = {
    id: Math.max(...adminData.universities.map((u) => u.id), 0) + 1,
    name,
    location,
    colleges: 0,
  }

  adminData.universities.push(newUniversity)
  loadUniversities()
  closeUniversityModal()
  showToast("University added successfully", "success")
}

function closeUniversityModal() {
  document.getElementById("universityModal").classList.remove("active")
  document.getElementById("universityForm").reset()
}

function loadColleges() {
  const tbody = document.getElementById("collegesTableBody")
  if (!tbody) return

  const selectUni = document.getElementById("filterUniversity")
  if (selectUni) {
    selectUni.innerHTML =
      '<option value="">All Universities</option>' +
      adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
  }

  const collegeUniSelect = document.getElementById("collegeUniversity")
  if (collegeUniSelect) {
    collegeUniSelect.innerHTML =
      '<option value="">Select University</option>' +
      adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
  }

  tbody.innerHTML = adminData.colleges
    .map((college) => {
      const uni = adminData.universities.find((u) => u.id === college.universityId)
      return `
      <tr>
        <td>${college.name}</td>
        <td>${uni ? uni.name : "N/A"}</td>
        <td>${college.students}</td>
        <td>${college.projects}</td>
        <td>
          <div class="action-buttons">
            <button class="btn-icon" onclick="editCollege(${college.id})">Edit</button>
            <button class="btn-icon btn-delete" onclick="deleteCollege(${college.id})">Delete</button>
          </div>
        </td>
      </tr>
    `
    })
    .join("")
}

function editCollege(id) {
  const college = adminData.colleges.find((c) => c.id === id)
  if (college) {
    document.getElementById("collegeName").value = college.name
    document.getElementById("collegeUniversity").value = college.universityId
    document.getElementById("collegeLocation").value = college.location
    document.getElementById("collegeModal").classList.add("active")
  }
}

function deleteCollege(id) {
  if (confirm("Are you sure you want to delete this college?")) {
    adminData.colleges = adminData.colleges.filter((c) => c.id !== id)
    loadColleges()
    showToast("College deleted successfully", "success")
  }
}

function handleCollegeSubmit(event) {
  event.preventDefault()
  const name = document.getElementById("collegeName").value
  const universityId = Number.parseInt(document.getElementById("collegeUniversity").value)
  const location = document.getElementById("collegeLocation").value

  const newCollege = {
    id: Math.max(...adminData.colleges.map((c) => c.id), 0) + 1,
    name,
    universityId,
    location,
    students: 0,
    projects: 0,
  }

  adminData.colleges.push(newCollege)
  loadColleges()
  closeCollegeModal()
  showToast("College added successfully", "success")
}

function closeCollegeModal() {
  document.getElementById("collegeModal").classList.remove("active")
  document.getElementById("collegeForm").reset()
}

// Event Listeners
function attachEventListeners() {
  const addUserBtn = document.getElementById("addUserBtn")
  if (addUserBtn) {
    addUserBtn.addEventListener("click", () => {
      document.getElementById("userForm").reset()
      document.getElementById("userModal").classList.add("active")
    })
  }

  const addAlgorithmBtn = document.getElementById("addAlgorithmBtn")
  if (addAlgorithmBtn) {
    addAlgorithmBtn.addEventListener("click", () => {
      document.getElementById("algorithmForm").reset()
      document.getElementById("algorithmModal").classList.add("active")
    })
  }

  const addUniversityBtn = document.getElementById("addUniversityBtn")
  if (addUniversityBtn) {
    addUniversityBtn.addEventListener("click", () => {
      document.getElementById("universityForm").reset()
      document.getElementById("universityModal").classList.add("active")
    })
  }

  const addCollegeBtn = document.getElementById("addCollegeBtn")
  if (addCollegeBtn) {
    addCollegeBtn.addEventListener("click", () => {
      document.getElementById("collegeForm").reset()
      document.getElementById("collegeModal").classList.add("active")
    })
  }

  // Close modals on outside click
  window.addEventListener("click", (e) => {
    const userModal = document.getElementById("userModal")
    const algorithmModal = document.getElementById("algorithmModal")
    const universityModal = document.getElementById("universityModal")
    const collegeModal = document.getElementById("collegeModal")

    if (e.target === userModal) userModal.classList.remove("active")
    if (e.target === algorithmModal) algorithmModal.classList.remove("active")
    if (e.target === universityModal) universityModal.classList.remove("active")
    if (e.target === collegeModal) collegeModal.classList.remove("active")
  })
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", initDashboard)
