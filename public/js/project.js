// Project Listing & Details Functionality

let filteredProjects = []
let currentPage = 1
const projectsPerPage = 6

const mockData = {
  projects: [
    // Sample project data
    {
      id: 1,
      title: "Project A",
      description: "Description of Project A",
      image: "path/to/image.jpg",
      college: "College A",
      university: "University A",
      semester: "Semester A",
      technologies: ["Tech A", "Tech B"],
      algorithms: ["Algo A", "Algo B"],
      likes: 10,
      comments: 5,
      teamMembers: ["Member A", "Member B"],
      githubLink: "https://github.com/projectA",
      liveDemo: "https://live-demo.com/projectA",
    },
    // Add more projects as needed
  ],
  colleges: [
    { name: "College A" },
    { name: "College B" },
    // Add more colleges as needed
  ],
  universities: [
    { name: "University A" },
    { name: "University B" },
    // Add more universities as needed
  ],
  semesters: ["Semester A", "Semester B"],
  technologies: ["Tech A", "Tech B"],
  algorithms: ["Algo A", "Algo B"],
}

function showToast(message, type = "success") {
  const container = document.querySelector(".toast-container") || createToastContainer()
  const toast = document.createElement("div")
  toast.className = `toast ${type}`
  toast.textContent = message
  container.appendChild(toast)

  setTimeout(() => {
    toast.style.opacity = "0"
    setTimeout(() => toast.remove(), 300)
  }, 3000)
}

function createToastContainer() {
  const container = document.createElement("div")
  container.className = "toast-container"
  document.body.appendChild(container)
  return container
}

// Initialize project listing page
function initProjectsPage() {
  populateFilters()
  filteredProjects = [...mockData.projects]
  displayProjects(filteredProjects)
  setupFilterListeners()
  setupSearchListener()
}

// Populate filter dropdowns
function populateFilters() {
  const collegeSelect = document.getElementById("college-filter")
  const universitySelect = document.getElementById("university-filter")
  const semesterSelect = document.getElementById("semester-filter")
  const techSelect = document.getElementById("tech-filter")
  const algoSelect = document.getElementById("algo-filter")

  if (collegeSelect) {
    mockData.colleges.forEach((college) => {
      const option = document.createElement("option")
      option.value = college.name
      option.textContent = college.name
      collegeSelect.appendChild(option)
    })
  }

  if (universitySelect) {
    mockData.universities.forEach((uni) => {
      const option = document.createElement("option")
      option.value = uni.name
      option.textContent = uni.name
      universitySelect.appendChild(option)
    })
  }

  if (semesterSelect) {
    mockData.semesters.forEach((sem) => {
      const option = document.createElement("option")
      option.value = sem
      option.textContent = sem
      semesterSelect.appendChild(option)
    })
  }

  if (techSelect) {
    mockData.technologies.forEach((tech) => {
      const option = document.createElement("option")
      option.value = tech
      option.textContent = tech
      techSelect.appendChild(option)
    })
  }

  if (algoSelect) {
    mockData.algorithms.forEach((algo) => {
      const option = document.createElement("option")
      option.value = algo
      option.textContent = algo
      algoSelect.appendChild(option)
    })
  }
}

// Setup filter listeners
function setupFilterListeners() {
  const filters = ["college-filter", "university-filter", "semester-filter", "tech-filter", "algo-filter"]

  filters.forEach((filterId) => {
    const element = document.getElementById(filterId)
    if (element) {
      element.addEventListener("change", applyFilters)
    }
  })
}

// Apply filters
function applyFilters() {
  const college = document.getElementById("college-filter")?.value || ""
  const university = document.getElementById("university-filter")?.value || ""
  const semester = document.getElementById("semester-filter")?.value || ""
  const tech = document.getElementById("tech-filter")?.value || ""
  const algo = document.getElementById("algo-filter")?.value || ""

  filteredProjects = mockData.projects.filter((project) => {
    return (
      (college === "" || project.college === college) &&
      (university === "" || project.university === university) &&
      (semester === "" || project.semester === semester) &&
      (tech === "" || project.technologies.includes(tech)) &&
      (algo === "" || project.algorithms.includes(algo))
    )
  })

  currentPage = 1
  displayProjects(filteredProjects)
}

// Setup search listener
function setupSearchListener() {
  const searchInput = document.getElementById("search-projects")
  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      const query = e.target.value.toLowerCase()
      filteredProjects = mockData.projects.filter(
        (project) => project.title.toLowerCase().includes(query) || project.description.toLowerCase().includes(query),
      )
      currentPage = 1
      displayProjects(filteredProjects)
    })
  }
}

// Display projects in grid
function displayProjects(projects) {
  const container = document.getElementById("projects-container")
  if (!container) return

  if (projects.length === 0) {
    container.innerHTML =
      '<div style="grid-column: 1/-1; text-align: center; padding: 3rem;"><p style="color: var(--text-secondary); font-size: var(--font-size-lg);">No projects found. Try adjusting your filters.</p></div>'
    return
  }

  container.innerHTML = projects
    .map(
      (project) => `
    <div class="card">
      <img src="${project.image}" alt="${project.title}" class="card-image">
      <div class="card-body">
        <h3>${project.title}</h3>
        <p>${project.description.substring(0, 80)}...</p>
        <div style="margin: var(--spacing-md) 0;">
          ${project.technologies
            .slice(0, 2)
            .map((tech) => `<span class="tag tag-primary">${tech}</span>`)
            .join("")}
          ${project.technologies.length > 2 ? `<span class="tag" style="color: var(--text-light);">+${project.technologies.length - 2} more</span>` : ""}
        </div>
        <p style="font-size: var(--font-size-sm); color: var(--text-light);">
          <strong>${project.college}</strong> | ${project.semester}
        </p>
      </div>
      <div class="card-footer">
        <a href="project.html?id=${project.id}" class="btn btn-primary btn-sm">View Details</a>
        <span style="color: var(--text-secondary); font-size: var(--font-size-sm);">❤️ ${project.likes}</span>
      </div>
    </div>
  `,
    )
    .join("")
}

// Display project details page
function displayProjectDetails() {
  const urlParams = new URLSearchParams(window.location.search)
  const projectId = Number.parseInt(urlParams.get("id"))
  const project = mockData.projects.find((p) => p.id === projectId)

  if (!project) {
    document.body.innerHTML =
      '<div class="container" style="padding: 3rem;"><h2>Project not found</h2><p><a href="projects.html">Back to Projects</a></p></div>'
    return
  }

  const container = document.getElementById("project-details")
  if (!container) return

  container.innerHTML = `
    <div class="grid-2" style="margin-bottom: var(--spacing-xl); gap: var(--spacing-xl);">
      <div>
        <img src="${project.image}" alt="${project.title}" style="width: 100%; border-radius: var(--radius-lg); margin-bottom: var(--spacing-lg); box-shadow: var(--shadow-lg);">
      </div>
      <div>
        <h1 style="margin-bottom: var(--spacing-md);">${project.title}</h1>
        <p style="font-size: var(--font-size-lg); color: var(--text-secondary); margin-bottom: var(--spacing-lg);">${project.description}</p>
        
        <div style="margin-bottom: var(--spacing-lg);">
          <h3 style="margin-bottom: var(--spacing-md);">Technologies</h3>
          <div class="chips">
            ${project.technologies.map((tech) => `<span class="tag tag-primary">${tech}</span>`).join("")}
          </div>
        </div>

        <div style="margin-bottom: var(--spacing-lg);">
          <h3 style="margin-bottom: var(--spacing-md);">Algorithms Used</h3>
          <div class="chips">
            ${project.algorithms.map((algo) => `<span class="tag tag-secondary">${algo}</span>`).join("")}
          </div>
        </div>

        <div style="margin-bottom: var(--spacing-lg); background: var(--bg-secondary); padding: var(--spacing-md); border-radius: var(--radius-lg);">
          <p style="margin-bottom: var(--spacing-sm);"><strong>College:</strong> ${project.college}</p>
          <p style="margin-bottom: var(--spacing-sm);"><strong>University:</strong> ${project.university}</p>
          <p style="margin-bottom: 0;"><strong>Semester:</strong> ${project.semester}</p>
        </div>

        <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-lg); flex-wrap: wrap;">
          <a href="${project.githubLink}" target="_blank" class="btn btn-primary">GitHub</a>
          <a href="${project.liveDemo}" target="_blank" class="btn btn-secondary">Live Demo</a>
        </div>

        <div style="display: flex; gap: var(--spacing-lg); align-items: center; padding: var(--spacing-md); background: var(--bg-secondary); border-radius: var(--radius-lg);">
          <button class="btn btn-outline" id="like-btn" style="cursor: pointer;">❤️ Like (${project.likes})</button>
          <span style="color: var(--text-secondary); font-size: var(--font-size-sm);">💬 ${project.comments} Comments</span>
        </div>
      </div>
    </div>

    <div style="margin-top: var(--spacing-xl);">
      <h2 style="margin-bottom: var(--spacing-lg);">Team Members</h2>
      <div class="grid-3">
        ${project.teamMembers
          .map(
            (member, index) => `
          <div class="card" style="text-align: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--secondary-light)); margin: 0 auto var(--spacing-md); display: flex; align-items: center; justify-content: center; color: white; font-size: var(--font-size-xl); font-weight: 700;">
              ${member.charAt(0).toUpperCase()}
            </div>
            <h4>${member}</h4>
            <p style="font-size: var(--font-size-sm); color: var(--text-light);">Team Member</p>
          </div>
        `,
          )
          .join("")}
      </div>
    </div>

    <div id="creator-profile-section" style="margin-top: var(--spacing-xl);"></div>

    <div style="margin-top: var(--spacing-xl);">
      <h2 style="margin-bottom: var(--spacing-lg);">Comments</h2>
      <div id="comments-section" style="display: flex; flex-direction: column; gap: var(--spacing-md);">
        <div class="card">
          <strong>Priya Sharma</strong>
          <p style="margin-top: var(--spacing-sm); color: var(--text-secondary);">This project is amazing! Great work on the UI/UX design. Would love to collaborate!</p>
        </div>
        <div class="card">
          <strong>Arun Singh</strong>
          <p style="margin-top: var(--spacing-sm); color: var(--text-secondary);">Could you share more details about the database structure and architecture?</p>
        </div>
      </div>
      <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-lg);">
        <input type="text" id="comment-input" placeholder="Write a comment..." style="flex: 1; padding: var(--spacing-sm); border: 1px solid var(--border); border-radius: var(--radius-md);">
        <button class="btn btn-primary" id="submit-comment-btn">Submit</button>
      </div>
    </div>

    <div id="related-projects" style="margin-top: var(--spacing-xl);">
      <h2 style="margin-bottom: var(--spacing-lg);">Related Projects</h2>
    </div>
  `

  displayCreatorProfile(project.teamMembers[0])

  loadAndDisplayComments(projectId, project.comments)

  displayRelatedProjects(projectId, project.technologies)

  // Like button functionality
  const likeBtn = document.getElementById("like-btn")
  if (likeBtn) {
    likeBtn.addEventListener("click", () => {
      project.likes++
      likeBtn.textContent = `❤️ Like (${project.likes})`
      localStorage.setItem(`project-${projectId}-likes`, project.likes)
      showToast("Project liked!", "success")
    })

    const savedLikes = localStorage.getItem(`project-${projectId}-likes`)
    if (savedLikes) {
      project.likes = Number.parseInt(savedLikes)
      likeBtn.textContent = `❤️ Like (${project.likes})`
    }
  }
}

function displayCreatorProfile(creatorName) {
  const section = document.getElementById("creator-profile-section")
  if (!section) return

  section.innerHTML = `
    <div class="card">
      <div style="display: flex; gap: var(--spacing-lg); align-items: center;">
        <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #6366F1, #818CF8); border-radius: 50%; font-size: 48px; font-weight: 700; color: white;">
          ${creatorName.charAt(0).toUpperCase()}
        </div>
        <div style="flex: 1;">
          <h3 style="margin-bottom: var(--spacing-sm);">${creatorName}</h3>
          <p style="color: var(--subtext); margin-bottom: var(--spacing-md);">Full Stack Developer | IOE Student</p>
          <button class="btn btn-primary" onclick="window.location.href='profile.html'" style="cursor: pointer;">View Full Profile</button>
        </div>
      </div>
    </div>
  `
}

function loadAndDisplayComments(projectId, initialCommentCount) {
  const commentsList = document.getElementById("comments-list")
  const submitBtn = document.getElementById("submit-comment-btn")
  const commentInput = document.getElementById("comment-input")

  // Load comments from localStorage
  const savedComments = JSON.parse(localStorage.getItem(`project-${projectId}-comments`) || "[]")

  const displayComments = () => {
    if (savedComments.length === 0) {
      commentsList.innerHTML = '<p style="color: var(--subtext);">No comments yet. Be the first to comment!</p>'
      return
    }

    commentsList.innerHTML = savedComments
      .map(
        (comment, idx) => `
      <div class="card">
        <div style="display: flex; gap: var(--spacing-md); align-items: start;">
          <div style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #6366F1, #818CF8); border-radius: 50%; font-weight: 700; color: white; flex-shrink: 0;">
            ${comment.author.charAt(0).toUpperCase()}
          </div>
          <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm);">
              <strong>${comment.author}</strong>
              <small style="color: var(--subtext);">${comment.date}</small>
            </div>
            <p style="color: var(--text);">${comment.text}</p>
          </div>
        </div>
      </div>
    `,
      )
      .join("")
  }

  displayComments()

  submitBtn.addEventListener("click", () => {
    const text = commentInput.value.trim()
    if (!text) {
      showToast("Please write a comment", "error")
      return
    }

    const newComment = {
      author: "You",
      text: text,
      date: new Date().toLocaleDateString(),
    }

    savedComments.push(newComment)
    localStorage.setItem(`project-${projectId}-comments`, JSON.stringify(savedComments))
    commentInput.value = ""
    displayComments()
    showToast("Comment posted!", "success")
  })
}

function displayRelatedProjects(currentProjectId, currentTechs) {
  const section = document.getElementById("related-projects")
  if (!section) return

  const related = mockData.projects
    .filter((p) => p.id !== currentProjectId && p.technologies.some((tech) => currentTechs.includes(tech)))
    .slice(0, 3)

  if (related.length === 0) {
    section.innerHTML = '<p style="grid-column: 1/-1; color: var(--subtext);">No related projects found</p>'
    return
  }

  section.innerHTML = related
    .map(
      (project) => `
    <div class="card">
      <img src="${project.image}" alt="${project.title}" class="card-image">
      <div class="card-body">
        <h3>${project.title}</h3>
        <p>${project.description.substring(0, 60)}...</p>
        <div style="margin: var(--spacing-md) 0;">
          ${project.technologies
            .slice(0, 2)
            .map((tech) => `<span class="tag">${tech}</span>`)
            .join("")}
        </div>
      </div>
      <div class="card-footer">
        <a href="project.html?id=${project.id}" class="btn btn-sm">View</a>
        <span>${project.likes} likes</span>
      </div>
    </div>
  `,
    )
    .join("")
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("projects-container")) {
    initProjectsPage()
  }
  if (document.getElementById("project-details")) {
    displayProjectDetails()
  }
})
