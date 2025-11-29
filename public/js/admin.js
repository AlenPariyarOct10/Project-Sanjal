// // Admin Dashboard JavaScript Module
//
// // In-memory data stores (would be backend in production)
// const adminData = {
//   users: [
//     {
//       id: 1,
//       name: "Ram Kumar",
//       email: "ram@example.com",
//       role: "student",
//       college: "IOE",
//       joined: "2024-01-15",
//       status: "active",
//     },
//     {
//       id: 2,
//       name: "Sita Sharma",
//       email: "sita@example.com",
//       role: "instructor",
//       college: "IOE",
//       joined: "2024-02-10",
//       status: "active",
//     },
//     {
//       id: 3,
//       name: "Hari Poudel",
//       email: "hari@example.com",
//       role: "student",
//       college: "Kantipur",
//       joined: "2024-03-05",
//       status: "inactive",
//     },
//     {
//       id: 4,
//       name: "Priya Mishra",
//       email: "priya@example.com",
//       role: "student",
//       college: "Bhaktapur",
//       joined: "2024-01-20",
//       status: "active",
//     },
//     {
//       id: 5,
//       name: "Arun Singh",
//       email: "arun@example.com",
//       role: "admin",
//       college: "IOE",
//       joined: "2023-12-01",
//       status: "active",
//     },
//   ],
//
//   algorithms: [
//     {
//       id: 1,
//       name: "Quick Sort",
//       category: "Sorting",
//       description: "Efficient divide-and-conquer sorting",
//       complexity: "O(n log n)",
//     },
//     {
//       id: 2,
//       name: "Binary Search",
//       category: "Searching",
//       description: "Fast search in sorted arrays",
//       complexity: "O(log n)",
//     },
//     { id: 3, name: "Dijkstra", category: "Graph", description: "Shortest path algorithm", complexity: "O(V²)" },
//     { id: 4, name: "Fibonacci", category: "DP", description: "Dynamic programming classic", complexity: "O(n)" },
//     {
//       id: 5,
//       name: "Merge Sort",
//       category: "Sorting",
//       description: "Stable sorting algorithm",
//       complexity: "O(n log n)",
//     },
//   ],
//
//   universities: [
//     { id: 1, name: "Tribhuvan University", location: "Kathmandu", colleges: 5 },
//     { id: 2, name: "Kathmandu University", location: "Dhulikhel", colleges: 3 },
//     { id: 3, name: "Pokhara University", location: "Pokhara", colleges: 2 },
//   ],
//
//   colleges: [
//     {
//       id: 1,
//       name: "Institute of Engineering (IOE)",
//       universityId: 1,
//       location: "Pulchowk",
//       students: 450,
//       projects: 28,
//     },
//     {
//       id: 2,
//       name: "Kantipur Engineering College",
//       universityId: 1,
//       location: "Kathmandu",
//       students: 250,
//       projects: 15,
//     },
//     {
//       id: 3,
//       name: "Bhaktapur Engineering College",
//       universityId: 1,
//       location: "Bhaktapur",
//       students: 200,
//       projects: 12,
//     },
//   ],
// }
//
// // Mock data declaration
// const mockData = {
//   projects: [
//     {
//       id: 1,
//       title: "Project A",
//       college: "IOE",
//       semester: "Fall 2024",
//       likes: 150,
//       comments: 30,
//       teamMembers: ["Alice", "Bob"],
//     },
//     {
//       id: 2,
//       title: "Project B",
//       college: "Kantipur",
//       semester: "Spring 2024",
//       likes: 200,
//       comments: 40,
//       teamMembers: ["Charlie", "David"],
//     },
//     {
//       id: 3,
//       title: "Project C",
//       college: "Bhaktapur",
//       semester: "Winter 2024",
//       likes: 100,
//       comments: 20,
//       teamMembers: ["Eve", "Frank"],
//     },
//   ],
// }
//
// // Show toast function declaration
// function showToast(message, type) {
//   const toast = document.createElement("div")
//   toast.className = `toast ${type}`
//   toast.textContent = message
//   document.body.appendChild(toast)
//
//   setTimeout(() => {
//     document.body.removeChild(toast)
//   }, 3000)
// }
//
// // Dashboard Initialization
// function initDashboard() {
//   const page = window.location.pathname.split("/").pop()
//
//   if (page === "admin-dashboard.html" || page === "") {
//     loadDashboardStats()
//     loadRecentProjects()
//     loadQuickStats()
//   } else if (page === "admin-users.html") {
//     loadUsers()
//     populateCollegeDropdown()
//   } else if (page === "admin-algorithms.html") {
//     loadAlgorithms()
//   } else if (page === "admin-institutions.html") {
//     loadUniversities()
//     loadColleges()
//   }
//
//   attachEventListeners()
// }
//
// // Dashboard Stats
// function loadDashboardStats() {
//   document.getElementById("totalUsers").textContent = adminData.users.length
//   document.getElementById("totalProjects").textContent = mockData.projects.length
//   document.getElementById("totalColleges").textContent = adminData.colleges.length
//   document.getElementById("totalAlgorithms").textContent = adminData.algorithms.length
// }
//
// function loadRecentProjects() {
//   const container = document.getElementById("recentProjects")
//   if (!container) return
//
//   const recentProjects = mockData.projects.slice(0, 3)
//   container.innerHTML = recentProjects
//     .map(
//       (project) => `
//     <div class="project-row">
//       <div class="project-info">
//         <h4>${project.title}</h4>
//         <div class="project-meta">${project.college} • ${project.semester}</div>
//       </div>
//       <div class="project-stats">
//         <div class="project-stat">
//           <div class="project-stat-value">${project.likes}</div>
//           <div class="project-stat-label">Likes</div>
//         </div>
//         <div class="project-stat">
//           <div class="project-stat-value">${project.comments}</div>
//           <div class="project-stat-label">Comments</div>
//         </div>
//         <div class="project-stat">
//           <div class="project-stat-value">${project.teamMembers.length}</div>
//           <div class="project-stat-label">Team</div>
//         </div>
//       </div>
//     </div>
//   `,
//     )
//     .join("")
// }
//
// function loadQuickStats() {
//   const techStats = {}
//   mockData.projects.forEach((project) => {
//     project.technologies.forEach((tech) => {
//       techStats[tech] = (techStats[tech] || 0) + 1
//     })
//   })
//
//   const techContainer = document.getElementById("techStats")
//   if (techContainer) {
//     techContainer.innerHTML = Object.entries(techStats)
//       .sort((a, b) => b[1] - a[1])
//       .slice(0, 5)
//       .map(
//         ([tech, count]) => `
//       <div class="stats-item">
//         <span class="stats-item-name">${tech}</span>
//         <span class="stats-item-count">${count}</span>
//       </div>
//     `,
//       )
//       .join("")
//   }
//
//   const algorithmStats = {}
//   mockData.projects.forEach((project) => {
//     project.algorithms.forEach((algo) => {
//       algorithmStats[algo] = (algorithmStats[algo] || 0) + 1
//     })
//   })
//
//   const algoContainer = document.getElementById("algorithmStats")
//   if (algoContainer) {
//     algoContainer.innerHTML = Object.entries(algorithmStats)
//       .sort((a, b) => b[1] - a[1])
//       .slice(0, 5)
//       .map(
//         ([algo, count]) => `
//       <div class="stats-item">
//         <span class="stats-item-name">${algo}</span>
//         <span class="stats-item-count">${count}</span>
//       </div>
//     `,
//       )
//       .join("")
//   }
// }
//
// // Users Management
// function loadUsers() {
//   const tbody = document.getElementById("usersTableBody")
//   if (!tbody) return
//
//   tbody.innerHTML = adminData.users
//     .map(
//       (user) => `
//     <tr>
//       <td>${user.name}</td>
//       <td>${user.email}</td>
//       <td>${user.role}</td>
//       <td>${user.college}</td>
//       <td>${new Date(user.joined).toLocaleDateString()}</td>
//       <td>
//         <span class="status-badge ${user.status === "active" ? "active" : "inactive"}">
//           ${user.status}
//         </span>
//       </td>
//       <td>
//         <div class="action-buttons">
//           <button class="btn-icon" onclick="editUser(${user.id})">Edit</button>
//           <button class="btn-icon btn-delete" onclick="deleteUser(${user.id})">Delete</button>
//         </div>
//       </td>
//     </tr>
//   `,
//     )
//     .join("")
// }
//
// function editUser(id) {
//   const user = adminData.users.find((u) => u.id === id)
//   if (user) {
//     document.getElementById("userName").value = user.name
//     document.getElementById("userEmail").value = user.email
//     document.getElementById("userRole").value = user.role
//     document.getElementById("userCollege").value = user.college
//     document.getElementById("userModal").classList.add("active")
//   }
// }
//
// function deleteUser(id) {
//   if (confirm("Are you sure you want to delete this user?")) {
//     adminData.users = adminData.users.filter((u) => u.id !== id)
//     loadUsers()
//     showToast("User deleted successfully", "success")
//   }
// }
//
// function handleUserSubmit(event) {
//   event.preventDefault()
//   const name = document.getElementById("userName").value
//   const email = document.getElementById("userEmail").value
//   const role = document.getElementById("userRole").value
//   const college = document.getElementById("userCollege").value
//
//   const newUser = {
//     id: Math.max(...adminData.users.map((u) => u.id), 0) + 1,
//     name,
//     email,
//     role,
//     college,
//     joined: new Date().toISOString().split("T")[0],
//     status: "active",
//   }
//
//   adminData.users.push(newUser)
//   loadUsers()
//   closeUserModal()
//   showToast("User added successfully", "success")
// }
//
// function closeUserModal() {
//   document.getElementById("userModal").classList.remove("active")
//   document.getElementById("userForm").reset()
// }
//
// function populateCollegeDropdown() {
//   const select = document.getElementById("userCollege")
//   if (select) {
//     select.innerHTML =
//       '<option value="">Select College</option>' +
//       adminData.colleges.map((c) => `<option value="${c.name}">${c.name}</option>`).join("")
//   }
// }
//
// // Algorithms Management
// function loadAlgorithms() {
//   const container = document.getElementById("algorithmsGrid")
//   if (!container) return
//
//   container.innerHTML = adminData.algorithms
//     .map(
//       (algo) => `
//     <div class="algorithm-card">
//       <h4>${algo.name}</h4>
//       <div class="algorithm-meta">
//         <span><strong>Category:</strong> ${algo.category}</span>
//       </div>
//       <p class="algorithm-description">${algo.description}</p>
//       <div class="algorithm-complexity">${algo.complexity}</div>
//       <div class="action-buttons">
//         <button class="btn-icon" onclick="editAlgorithm(${algo.id})">Edit</button>
//         <button class="btn-icon btn-delete" onclick="deleteAlgorithm(${algo.id})">Delete</button>
//       </div>
//     </div>
//   `,
//     )
//     .join("")
// }
//
// function editAlgorithm(id) {
//   const algo = adminData.algorithms.find((a) => a.id === id)
//   if (algo) {
//     document.getElementById("algorithmName").value = algo.name
//     document.getElementById("algorithmCategory").value = algo.category
//     document.getElementById("algorithmDescription").value = algo.description
//     document.getElementById("algorithmComplexity").value = algo.complexity
//     document.getElementById("algorithmModal").classList.add("active")
//   }
// }
//
// function deleteAlgorithm(id) {
//   if (confirm("Are you sure you want to delete this algorithm?")) {
//     adminData.algorithms = adminData.algorithms.filter((a) => a.id !== id)
//     loadAlgorithms()
//     showToast("Algorithm deleted successfully", "success")
//   }
// }
//
// function handleAlgorithmSubmit(event) {
//   event.preventDefault()
//   const name = document.getElementById("algorithmName").value
//   const category = document.getElementById("algorithmCategory").value
//   const description = document.getElementById("algorithmDescription").value
//   const complexity = document.getElementById("algorithmComplexity").value
//
//   const newAlgorithm = {
//     id: Math.max(...adminData.algorithms.map((a) => a.id), 0) + 1,
//     name,
//     category,
//     description,
//     complexity,
//   }
//
//   adminData.algorithms.push(newAlgorithm)
//   loadAlgorithms()
//   closeAlgorithmModal()
//   showToast("Algorithm added successfully", "success")
// }
//
// function closeAlgorithmModal() {
//   document.getElementById("algorithmModal").classList.remove("active")
//   document.getElementById("algorithmForm").reset()
// }
//
// // Universities & Colleges Management
// function loadUniversities() {
//   const container = document.getElementById("universitiesGrid")
//   if (!container) return
//
//   container.innerHTML = adminData.universities
//     .map(
//       (uni) => `
//     <div class="institution-card">
//       <h4>${uni.name}</h4>
//       <div class="institution-info">
//         <strong>Location:</strong> ${uni.location}
//       </div>
//       <div class="institution-info">
//         <strong>Colleges:</strong> ${uni.colleges}
//       </div>
//       <div class="action-buttons">
//         <button class="btn-icon" onclick="editUniversity(${uni.id})">Edit</button>
//         <button class="btn-icon btn-delete" onclick="deleteUniversity(${uni.id})">Delete</button>
//       </div>
//     </div>
//   `,
//     )
//     .join("")
//
//   const filterSelect = document.getElementById("filterUniversity")
//   if (filterSelect) {
//     filterSelect.innerHTML =
//       '<option value="">All Universities</option>' +
//       adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
//   }
// }
//
// function editUniversity(id) {
//   const uni = adminData.universities.find((u) => u.id === id)
//   if (uni) {
//     document.getElementById("universityName").value = uni.name
//     document.getElementById("universityLocation").value = uni.location
//     document.getElementById("universityModal").classList.add("active")
//   }
// }
//
// function deleteUniversity(id) {
//   if (confirm("Are you sure you want to delete this university?")) {
//     adminData.universities = adminData.universities.filter((u) => u.id !== id)
//     loadUniversities()
//     showToast("University deleted successfully", "success")
//   }
// }
//
// function handleUniversitySubmit(event) {
//   event.preventDefault()
//   const name = document.getElementById("universityName").value
//   const location = document.getElementById("universityLocation").value
//
//   const newUniversity = {
//     id: Math.max(...adminData.universities.map((u) => u.id), 0) + 1,
//     name,
//     location,
//     colleges: 0,
//   }
//
//   adminData.universities.push(newUniversity)
//   loadUniversities()
//   closeUniversityModal()
//   showToast("University added successfully", "success")
// }
//
// function closeUniversityModal() {
//   document.getElementById("universityModal").classList.remove("active")
//   document.getElementById("universityForm").reset()
// }
//
// function loadColleges() {
//   const tbody = document.getElementById("collegesTableBody")
//   if (!tbody) return
//
//   const selectUni = document.getElementById("filterUniversity")
//   if (selectUni) {
//     selectUni.innerHTML =
//       '<option value="">All Universities</option>' +
//       adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
//   }
//
//   const collegeUniSelect = document.getElementById("collegeUniversity")
//   if (collegeUniSelect) {
//     collegeUniSelect.innerHTML =
//       '<option value="">Select University</option>' +
//       adminData.universities.map((u) => `<option value="${u.id}">${u.name}</option>`).join("")
//   }
//
//   tbody.innerHTML = adminData.colleges
//     .map((college) => {
//       const uni = adminData.universities.find((u) => u.id === college.universityId)
//       return `
//       <tr>
//         <td>${college.name}</td>
//         <td>${uni ? uni.name : "N/A"}</td>
//         <td>${college.students}</td>
//         <td>${college.projects}</td>
//         <td>
//           <div class="action-buttons">
//             <button class="btn-icon" onclick="editCollege(${college.id})">Edit</button>
//             <button class="btn-icon btn-delete" onclick="deleteCollege(${college.id})">Delete</button>
//           </div>
//         </td>
//       </tr>
//     `
//     })
//     .join("")
// }
//
// function editCollege(id) {
//   const college = adminData.colleges.find((c) => c.id === id)
//   if (college) {
//     document.getElementById("collegeName").value = college.name
//     document.getElementById("collegeUniversity").value = college.universityId
//     document.getElementById("collegeLocation").value = college.location
//     document.getElementById("collegeModal").classList.add("active")
//   }
// }
//
// function deleteCollege(id) {
//   if (confirm("Are you sure you want to delete this college?")) {
//     adminData.colleges = adminData.colleges.filter((c) => c.id !== id)
//     loadColleges()
//     showToast("College deleted successfully", "success")
//   }
// }
//
// function handleCollegeSubmit(event) {
//   event.preventDefault()
//   const name = document.getElementById("collegeName").value
//   const universityId = Number.parseInt(document.getElementById("collegeUniversity").value)
//   const location = document.getElementById("collegeLocation").value
//
//   const newCollege = {
//     id: Math.max(...adminData.colleges.map((c) => c.id), 0) + 1,
//     name,
//     universityId,
//     location,
//     students: 0,
//     projects: 0,
//   }
//
//   adminData.colleges.push(newCollege)
//   loadColleges()
//   closeCollegeModal()
//   showToast("College added successfully", "success")
// }
//
// function closeCollegeModal() {
//   document.getElementById("collegeModal").classList.remove("active")
//   document.getElementById("collegeForm").reset()
// }
//
// // Event Listeners
// function attachEventListeners() {
//   const addUserBtn = document.getElementById("addUserBtn")
//   if (addUserBtn) {
//     addUserBtn.addEventListener("click", () => {
//       document.getElementById("userForm").reset()
//       document.getElementById("userModal").classList.add("active")
//     })
//   }
//
//   const addAlgorithmBtn = document.getElementById("addAlgorithmBtn")
//   if (addAlgorithmBtn) {
//     addAlgorithmBtn.addEventListener("click", () => {
//       document.getElementById("algorithmForm").reset()
//       document.getElementById("algorithmModal").classList.add("active")
//     })
//   }
//
//   const addUniversityBtn = document.getElementById("addUniversityBtn")
//   if (addUniversityBtn) {
//     addUniversityBtn.addEventListener("click", () => {
//       document.getElementById("universityForm").reset()
//       document.getElementById("universityModal").classList.add("active")
//     })
//   }
//
//   const addCollegeBtn = document.getElementById("addCollegeBtn")
//   if (addCollegeBtn) {
//     addCollegeBtn.addEventListener("click", () => {
//       document.getElementById("collegeForm").reset()
//       document.getElementById("collegeModal").classList.add("active")
//     })
//   }
//
//   // Close modals on outside click
//   window.addEventListener("click", (e) => {
//     const userModal = document.getElementById("userModal")
//     const algorithmModal = document.getElementById("algorithmModal")
//     const universityModal = document.getElementById("universityModal")
//     const collegeModal = document.getElementById("collegeModal")
//
//     if (e.target === userModal) userModal.classList.remove("active")
//     if (e.target === algorithmModal) algorithmModal.classList.remove("active")
//     if (e.target === universityModal) universityModal.classList.remove("active")
//     if (e.target === collegeModal) collegeModal.classList.remove("active")
//   })
// }
//
// // Initialize when DOM is ready
// document.addEventListener("DOMContentLoaded", initDashboard)
