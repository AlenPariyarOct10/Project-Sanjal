// Institution Pages - Colleges, Universities, and Details

const mockData = {
  colleges: [
    { id: 1, name: "College A", universityId: 1 },
    { id: 2, name: "College B", universityId: 2 },
  ],
  universities: [
    { id: 1, name: "University X" },
    { id: 2, name: "University Y" },
  ],
  projects: [
    {
      id: 1,
      title: "Project 1",
      description: "Description of project 1",
      college: "College A",
      university: "University X",
      technologies: ["Tech1", "Tech2"],
      algorithms: ["Algo1"],
    },
    {
      id: 2,
      title: "Project 2",
      description: "Description of project 2",
      college: "College B",
      university: "University Y",
      technologies: ["Tech3"],
      algorithms: ["Algo2"],
    },
  ],
}

// Colleges Listing Page
function initCollegesPage() {
  const collegesList = document.getElementById("collegesList")
  const collegeSearch = document.getElementById("collegeSearch")

  if (!collegesList) return

  function renderColleges(colleges = mockData.colleges) {
    collegesList.innerHTML = ""
    colleges.forEach((college) => {
      const university = mockData.universities.find((u) => u.id === college.universityId)
      const projectCount = mockData.projects.filter((p) => p.college === college.name).length

      const collegeCard = document.createElement("div")
      collegeCard.className = "card"
      collegeCard.innerHTML = `
        <div class="card-header">
          <h3>${college.name}</h3>
          <p style="color: var(--subtext); font-size: 14px; margin: var(--sp-8) 0 0 0;">${university.name}</p>
        </div>
        <div class="card-body">
          <p>Projects: <strong>${projectCount}</strong></p>
        </div>
        <div class="card-footer">
          <a href="college-detail.html?id=${college.id}" class="btn btn-sm">View Details</a>
        </div>
      `
      collegesList.appendChild(collegeCard)
    })
  }

  renderColleges()

  if (collegeSearch) {
    collegeSearch.addEventListener("input", (e) => {
      const filtered = mockData.colleges.filter((c) => c.name.toLowerCase().includes(e.target.value.toLowerCase()))
      renderColleges(filtered)
    })
  }
}

// Universities Listing Page
function initUniversitiesPage() {
  const universitiesList = document.getElementById("universitiesList")
  const universitySearch = document.getElementById("universitySearch")

  if (!universitiesList) return

  function renderUniversities(universities = mockData.universities) {
    universitiesList.innerHTML = ""
    universities.forEach((university) => {
      const collegeCount = mockData.colleges.filter((c) => c.universityId === university.id).length
      const projectCount = mockData.projects.filter((p) => p.university === university.name).length

      const uniCard = document.createElement("div")
      uniCard.className = "card"
      uniCard.innerHTML = `
        <div class="card-header">
          <h3>${university.name}</h3>
        </div>
        <div class="card-body">
          <p>Colleges: <strong>${collegeCount}</strong></p>
          <p>Projects: <strong>${projectCount}</strong></p>
        </div>
        <div class="card-footer">
          <a href="university-detail.html?id=${university.id}" class="btn btn-sm">View Details</a>
        </div>
      `
      universitiesList.appendChild(uniCard)
    })
  }

  renderUniversities()

  if (universitySearch) {
    universitySearch.addEventListener("input", (e) => {
      const filtered = mockData.universities.filter((u) => u.name.toLowerCase().includes(e.target.value.toLowerCase()))
      renderUniversities(filtered)
    })
  }
}

// College Detail Page
function initCollegeDetailPage() {
  const detailContainer = document.getElementById("collegeDetailContainer")
  const projectsContainer = document.getElementById("collegeProjects")
  const technologiesContainer = document.getElementById("collegeTechnologies")
  const algorithmsContainer = document.getElementById("collegeAlgorithms")

  if (!detailContainer) return

  const params = new URLSearchParams(window.location.search)
  const collegeId = Number.parseInt(params.get("id"))
  const college = mockData.colleges.find((c) => c.id === collegeId)

  if (!college) {
    detailContainer.innerHTML = "<p>College not found</p>"
    return
  }

  const university = mockData.universities.find((u) => u.id === college.universityId)
  const collegeProjects = mockData.projects.filter((p) => p.college === college.name)

  // Render college header
  detailContainer.innerHTML = `
    <div style="margin-bottom: var(--sp-32);">
      <a href="colleges.html" style="color: var(--subtext); text-decoration: underline;">← Back to Colleges</a>
      <h1 style="margin-top: var(--sp-16);">${college.name}</h1>
      <p style="font-size: 18px; color: var(--subtext);">University: ${university.name}</p>
      <p style="color: var(--subtext); margin-top: var(--sp-16);">Total Projects: ${collegeProjects.length}</p>
    </div>
  `

  // Render projects
  if (projectsContainer) {
    projectsContainer.innerHTML = ""
    if (collegeProjects.length === 0) {
      projectsContainer.innerHTML = "<p style='grid-column: 1/-1;'>No projects found for this college</p>"
    } else {
      collegeProjects.forEach((project) => {
        const projectCard = document.createElement("div")
        projectCard.className = "card"
        projectCard.innerHTML = `
          <img src="${project.image}" alt="${project.title}" class="card-image">
          <div class="card-header">
            <h3>${project.title}</h3>
          </div>
          <div class="card-body">
            <p>${project.description.substring(0, 80)}...</p>
          </div>
          <div class="card-footer">
            <a href="project.html?id=${project.id}" class="btn btn-sm">View Project</a>
            <span style="color: var(--subtext);">👍 ${project.likes}</span>
          </div>
        `
        projectsContainer.appendChild(projectCard)
      })
    }
  }

  // Extract and render technologies
  if (technologiesContainer) {
    const techSet = new Set()
    collegeProjects.forEach((p) => p.technologies.forEach((t) => techSet.add(t)))
    technologiesContainer.innerHTML = Array.from(techSet)
      .map((tech) => `<div class="chip">${tech}</div>`)
      .join("")
  }

  // Extract and render algorithms
  if (algorithmsContainer) {
    const algoSet = new Set()
    collegeProjects.forEach((p) => p.algorithms.forEach((a) => algoSet.add(a)))
    algorithmsContainer.innerHTML = Array.from(algoSet)
      .map((algo) => `<div class="chip">${algo}</div>`)
      .join("")
  }
}

// University Detail Page
function initUniversityDetailPage() {
  const detailContainer = document.getElementById("universityDetailContainer")
  const collegesContainer = document.getElementById("universityColleges")
  const projectsContainer = document.getElementById("universityProjects")
  const technologiesContainer = document.getElementById("universityTechnologies")
  const algorithmsContainer = document.getElementById("universityAlgorithms")

  if (!detailContainer) return

  const params = new URLSearchParams(window.location.search)
  const universityId = Number.parseInt(params.get("id"))
  const university = mockData.universities.find((u) => u.id === universityId)

  if (!university) {
    detailContainer.innerHTML = "<p>University not found</p>"
    return
  }

  const universityColleges = mockData.colleges.filter((c) => c.universityId === universityId)
  const universityProjects = mockData.projects.filter((p) => p.university === university.name)

  // Render university header
  detailContainer.innerHTML = `
    <div style="margin-bottom: var(--sp-32);">
      <a href="universities.html" style="color: var(--subtext); text-decoration: underline;">← Back to Universities</a>
      <h1 style="margin-top: var(--sp-16);">${university.name}</h1>
      <p style="color: var(--subtext); margin-top: var(--sp-16);">Total Colleges: ${universityColleges.length} | Total Projects: ${universityProjects.length}</p>
    </div>
  `

  // Render colleges
  if (collegesContainer) {
    collegesContainer.innerHTML = ""
    universityColleges.forEach((college) => {
      const collegeProjectCount = mockData.projects.filter((p) => p.college === college.name).length
      const collegeCard = document.createElement("div")
      collegeCard.className = "card"
      collegeCard.innerHTML = `
        <div class="card-header">
          <h3>${college.name}</h3>
        </div>
        <div class="card-body">
          <p>Projects: <strong>${collegeProjectCount}</strong></p>
        </div>
        <div class="card-footer">
          <a href="college-detail.html?id=${college.id}" class="btn btn-sm">View Details</a>
        </div>
      `
      collegesContainer.appendChild(collegeCard)
    })
  }

  // Render projects
  if (projectsContainer) {
    projectsContainer.innerHTML = ""
    if (universityProjects.length === 0) {
      projectsContainer.innerHTML = "<p style='grid-column: 1/-1;'>No projects found for this university</p>"
    } else {
      universityProjects.forEach((project) => {
        const projectCard = document.createElement("div")
        projectCard.className = "card"
        projectCard.innerHTML = `
          <img src="${project.image}" alt="${project.title}" class="card-image">
          <div class="card-header">
            <h3>${project.title}</h3>
          </div>
          <div class="card-body">
            <p>${project.description.substring(0, 80)}...</p>
          </div>
          <div class="card-footer">
            <a href="project.html?id=${project.id}" class="btn btn-sm">View Project</a>
            <span style="color: var(--subtext);">👍 ${project.likes}</span>
          </div>
        `
        projectsContainer.appendChild(projectCard)
      })
    }
  }

  // Extract and render technologies
  if (technologiesContainer) {
    const techSet = new Set()
    universityProjects.forEach((p) => p.technologies.forEach((t) => techSet.add(t)))
    technologiesContainer.innerHTML = Array.from(techSet)
      .map((tech) => `<div class="chip">${tech}</div>`)
      .join("")
  }

  // Extract and render algorithms
  if (algorithmsContainer) {
    const algoSet = new Set()
    universityProjects.forEach((p) => p.algorithms.forEach((a) => algoSet.add(a)))
    algorithmsContainer.innerHTML = Array.from(algoSet)
      .map((algo) => `<div class="chip">${algo}</div>`)
      .join("")
  }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  initCollegesPage()
  initUniversitiesPage()
  initCollegeDetailPage()
  initUniversityDetailPage()
})
