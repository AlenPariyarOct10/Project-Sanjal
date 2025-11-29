// Project Submission Form Functionality

let teamMembers = []
const mockData = {
  colleges: [{ name: "College A" }, { name: "College B" }],
  universities: [{ name: "University A" }, { name: "University B" }],
  semesters: ["Fall", "Spring", "Summer"],
  technologies: ["JavaScript", "React", "Node.js"],
  algorithms: ["Sorting", "Searching", "Graph"],
  projects: [],
}

function showToast(message, type = "success") {
  alert(`${type.toUpperCase()}: ${message}`)
}

// Initialize submit page
function initSubmitPage() {
  setupTeamMemberAdd()
  setupImagePreview()
  setupFormSubmit()
  populateFormSelects()
}

// Populate form selects with mockData
function populateFormSelects() {
  const collegeSelect = document.getElementById("college")
  const universitySelect = document.getElementById("university")
  const semesterSelect = document.getElementById("semester")
  const techSelect = document.getElementById("technologies")
  const algoSelect = document.getElementById("algorithms")

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

// Setup team member add
function setupTeamMemberAdd() {
  const addBtn = document.getElementById("add-member-btn")
  const memberInput = document.getElementById("member-input")

  if (addBtn && memberInput) {
    addBtn.addEventListener("click", (e) => {
      e.preventDefault()
      const memberName = memberInput.value.trim()

      if (!memberName) {
        showToast("Please enter a team member name", "error")
        return
      }

      if (teamMembers.includes(memberName)) {
        showToast("Team member already added", "warning")
        return
      }

      teamMembers.push(memberName)
      memberInput.value = ""
      memberInput.focus()
      renderTeamMembers()
      showToast("Team member added!", "success")
    })

    memberInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault()
        addBtn.click()
      }
    })
  }
}

// Render team members list
function renderTeamMembers() {
  const membersList = document.getElementById("team-members-list")
  if (!membersList) return

  membersList.innerHTML = teamMembers
    .map(
      (member, index) => `
    <div class="tag" style="display: inline-flex; align-items: center; gap: var(--spacing-sm); background: var(--primary-light); border-color: var(--primary-color);">
      ${member}
      <button type="button" class="remove-member" data-index="${index}" style="background: none; border: none; cursor: pointer; color: var(--primary-color); font-weight: bold; font-size: 16px; padding: 0; line-height: 1;">×</button>
    </div>
  `,
    )
    .join("")

  // Setup remove buttons
  document.querySelectorAll(".remove-member").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault()
      const index = Number.parseInt(e.target.dataset.index)
      const removed = teamMembers[index]
      teamMembers.splice(index, 1)
      renderTeamMembers()
      showToast(`${removed} removed from team`, "success")
    })
  })
}

// Setup image preview
function setupImagePreview() {
  const fileInput = document.getElementById("file-upload")
  const previewContainer = document.getElementById("file-preview")

  if (fileInput && previewContainer) {
    fileInput.addEventListener("change", (e) => {
      const files = e.target.files
      previewContainer.innerHTML = ""

      for (const file of files) {
        if (file.type.startsWith("image/")) {
          const reader = new FileReader()
          reader.onload = (event) => {
            const preview = document.createElement("div")
            preview.style.cssText = "position: relative; display: inline-block; margin: var(--spacing-md);"
            preview.innerHTML = `
              <img src="${event.target.result}" alt="Preview" style="width: 150px; height: 150px; object-fit: cover; border-radius: var(--radius-lg); border: 2px solid var(--primary-color); box-shadow: var(--shadow-md);">
              <span style="position: absolute; top: 5px; right: 5px; background: var(--success-color); color: white; padding: 4px 8px; border-radius: var(--radius-md); font-size: var(--font-size-sm); font-weight: 600;">✓</span>
            `
            previewContainer.appendChild(preview)
          }
          reader.readAsDataURL(file)
        } else {
          const preview = document.createElement("div")
          preview.style.cssText =
            "padding: var(--spacing-md); background: var(--bg-secondary); border-radius: var(--radius-lg); margin: var(--spacing-md); text-align: center; border: 1px solid var(--border-color);"
          preview.innerHTML = `<strong>📁 ${file.name}</strong><p style="font-size: var(--font-size-sm); color: var(--text-light); margin-top: var(--spacing-sm);">${(file.size / 1024).toFixed(2)} KB</p>`
          previewContainer.appendChild(preview)
        }
      }
    })
  }
}

// Setup form submit
function setupFormSubmit() {
  const form = document.getElementById("submit-form")
  if (!form) return

  form.addEventListener("submit", (e) => {
    e.preventDefault()

    // Get form values
    const title = document.getElementById("title").value.trim()
    const description = document.getElementById("description").value.trim()
    const college = document.getElementById("college").value
    const university = document.getElementById("university").value
    const semester = document.getElementById("semester").value
    const github = document.getElementById("github-link").value.trim()
    const liveDemo = document.getElementById("live-demo-link").value.trim()

    // Validate required fields
    if (!title || !description || !college || !university || !semester || teamMembers.length === 0) {
      showToast("Please fill all required fields and add at least one team member", "error")
      return
    }

    // Get selected technologies and algorithms
    const techSelect = document.getElementById("technologies")
    const algoSelect = document.getElementById("algorithms")
    const selectedTechs = Array.from(techSelect.selectedOptions).map((o) => o.value)
    const selectedAlgos = Array.from(algoSelect.selectedOptions).map((o) => o.value)

    // Create project object
    const newProject = {
      id: mockData.projects.length + 1,
      title,
      description,
      image: "/placeholder.svg?key=9ynnd",
      technologies: selectedTechs.length > 0 ? selectedTechs : ["General"],
      algorithms: selectedAlgos.length > 0 ? selectedAlgos : ["General"],
      college,
      university,
      semester,
      teamMembers: [...teamMembers],
      githubLink: github || "#",
      liveDemo: liveDemo || "#",
      likes: 0,
      comments: 0,
    }

    // Save to localStorage and mockData
    const projects = JSON.parse(localStorage.getItem("submitted-projects") || "[]")
    projects.push(newProject)
    localStorage.setItem("submitted-projects", JSON.stringify(projects))
    mockData.projects.push(newProject)

    showToast("Project submitted successfully! Your project will be reviewed soon.", "success")

    // Reset form
    form.reset()
    teamMembers = []
    renderTeamMembers()
    document.getElementById("file-preview").innerHTML = ""

    // Redirect after 2 seconds
    setTimeout(() => {
      window.location.href = "projects.html"
    }, 2000)
  })
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("submit-form")) {
    initSubmitPage()
  }
})
