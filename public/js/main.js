// // Nepal IT Project Hub - Main JavaScript Module
//
// // Mock Data
// const mockData = {
//   universities: [
//     { id: 1, name: "Tribhuvan University" },
//     { id: 2, name: "Kathmandu University" },
//     { id: 3, name: "Pokhara University" },
//     { id: 4, name: "Nepal Academy of Science and Technology" },
//     { id: 5, name: "Purbanchal University" },
//   ],
//
//   colleges: [
//     { id: 1, name: "Institute of Engineering (IOE)", universityId: 1 },
//     { id: 2, name: "Bhaktapur Engineering College", universityId: 1 },
//     { id: 3, name: "Kantipur Engineering College", universityId: 1 },
//     { id: 4, name: "Kathmandu Engineering College", universityId: 2 },
//     { id: 5, name: "Pulchowk Campus", universityId: 1 },
//   ],
//
//   technologies: [
//     "JavaScript",
//     "Python",
//     "React",
//     "Vue.js",
//     "Node.js",
//     "Django",
//     "Flask",
//     "PHP",
//     "Laravel",
//     "Java",
//     "Spring Boot",
//     "C++",
//     "C#",
//     ".NET",
//     "Angular",
//     "TypeScript",
//     "MongoDB",
//     "PostgreSQL",
//     "MySQL",
//     "Firebase",
//     "AWS",
//     "Azure",
//   ],
//
//   algorithms: [
//     "Sorting",
//     "Searching",
//     "Graph Algorithms",
//     "Dynamic Programming",
//     "Greedy Algorithms",
//     "Backtracking",
//     "BFS",
//     "DFS",
//     "Dijkstra",
//     "Kruskal",
//     "Prim",
//     "Floyd-Warshall",
//     "Binary Search",
//   ],
//
//   semesters: [
//     "1st Semester",
//     "2nd Semester",
//     "3rd Semester",
//     "4th Semester",
//     "5th Semester",
//     "6th Semester",
//     "7th Semester",
//     "8th Semester",
//   ],
//
//   projects: [
//     {
//       id: 1,
//       title: "E-Commerce Platform",
//       description: "A full-stack e-commerce platform with payment gateway integration",
//       image: "/ecommerce-platform.jpg",
//       technologies: ["React", "Node.js", "MongoDB", "Stripe"],
//       algorithms: ["Sorting", "Searching"],
//       college: "Institute of Engineering (IOE)",
//       university: "Tribhuvan University",
//       semester: "7th Semester",
//       teamMembers: ["Ram Kumar", "Sita Sharma", "Hari Poudel"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 45,
//       comments: 8,
//     },
//     {
//       id: 2,
//       title: "Social Media App",
//       description: "A modern social media platform with real-time messaging",
//       image: "/social-media-app.jpg",
//       technologies: ["React", "Firebase", "Redux"],
//       algorithms: ["Graph Algorithms", "BFS"],
//       college: "Kantipur Engineering College",
//       university: "Tribhuvan University",
//       semester: "6th Semester",
//       teamMembers: ["Priya Mishra", "Arun Singh"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 67,
//       comments: 12,
//     },
//     {
//       id: 3,
//       title: "Machine Learning Chatbot",
//       description: "An AI-powered chatbot using NLP for customer support",
//       image: "/ai-chatbot-concept.png",
//       technologies: ["Python", "Flask", "TensorFlow", "MongoDB"],
//       algorithms: ["Dynamic Programming", "Greedy Algorithms"],
//       college: "Bhaktapur Engineering College",
//       university: "Tribhuvan University",
//       semester: "8th Semester",
//       teamMembers: ["Nikhil Patel", "Deepak Sharma"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 89,
//       comments: 15,
//     },
//     {
//       id: 4,
//       title: "Weather Forecasting App",
//       description: "Real-time weather app with location-based forecasts",
//       image: "/weather-app-interface.png",
//       technologies: ["React Native", "OpenWeather API", "Redux"],
//       algorithms: ["Sorting", "Searching"],
//       college: "Kathmandu Engineering College",
//       university: "Kathmandu University",
//       semester: "5th Semester",
//       teamMembers: ["Meera Gupta"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 34,
//       comments: 5,
//     },
//     {
//       id: 5,
//       title: "Task Management System",
//       description: "Collaborative task management tool with team features",
//       image: "/task-management-board.png",
//       technologies: ["Vue.js", "Laravel", "PostgreSQL"],
//       algorithms: ["Searching", "Sorting"],
//       college: "Institute of Engineering (IOE)",
//       university: "Tribhuvan University",
//       semester: "6th Semester",
//       teamMembers: ["Anuj Kumar", "Priya Sharma", "Rohit Singh"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 56,
//       comments: 9,
//     },
//     {
//       id: 6,
//       title: "File Sharing System",
//       description: "Secure file sharing platform with encryption",
//       image: "/file-sharing.jpg",
//       technologies: ["Node.js", "React", "AWS S3", "PostgreSQL"],
//       algorithms: ["Encryption Algorithms", "BFS"],
//       college: "Pulchowk Campus",
//       university: "Tribhuvan University",
//       semester: "7th Semester",
//       teamMembers: ["Vikram Singh", "Swati Sharma"],
//       githubLink: "https://github.com",
//       liveDemo: "https://example.com",
//       likes: 72,
//       comments: 11,
//     },
//   ],
// }
//
// // Utility Functions
// function showToast(message, type = "success") {
//   const container = document.querySelector(".toast-container") || createToastContainer()
//   const toast = document.createElement("div")
//   toast.className = `toast ${type}`
//   toast.textContent = message
//   container.appendChild(toast)
//
//   setTimeout(() => {
//     toast.style.animation = "fadeOut 0.3s ease"
//     setTimeout(() => toast.remove(), 300)
//   }, 3000)
// }
//
// function createToastContainer() {
//   const container = document.createElement("div")
//   container.className = "toast-container"
//   document.body.appendChild(container)
//   return container
// }
//
// // Mobile Menu Toggle
// function initMobileMenu() {
//   const toggle = document.querySelector(".nav-toggle")
//   const navLinks = document.querySelector(".nav-links")
//
//   if (toggle) {
//     toggle.addEventListener("click", () => {
//       navLinks.classList.toggle("active")
//     })
//
//     document.addEventListener("click", (e) => {
//       if (!e.target.closest("nav")) {
//         navLinks.classList.remove("active")
//       }
//     })
//   }
// }
//
// // Initialize on page load
// document.addEventListener("DOMContentLoaded", initMobileMenu)
//
// // Export for use in other modules
// if (typeof module !== "undefined" && module.exports) {
//   module.exports = { mockData, showToast, createToastContainer }
// }
