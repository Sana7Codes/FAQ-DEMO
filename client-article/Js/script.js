// Set API Base URL 
const API_BASE_URL = "http://192.168.1.103/FAQ-DEMO/server-article/api/v1/";

document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    if (window.location.pathname.includes("home.html")) {
        fetchAndRenderFAQs();
    }
    if (document.getElementById("signupForm")) {
        document.getElementById("signupForm").addEventListener("submit", signUpUser);
    }
    if (document.getElementById("loginForm")) {
        document.getElementById("loginForm").addEventListener("submit", loginUser);
    }
});

function setupEventListeners() {
    const actions = {
        contributeIcon: () => window.location.href = "contribute.html",
        contributeForm: contributeQuestion,
        searchBar: filterQuestions
    };

    Object.keys(actions).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener(id === "searchBar" ? "input" : "click", actions[id]);
        }
    });
}

// API Helpers
function sendPost(url, data) {
    return axios.post(API_BASE_URL + url, data);
}

function sendGet(url) {
    return axios.get(API_BASE_URL + url);
}

// Fetch FAQs
function fetchAndRenderFAQs() {
    const url = "faq.php";
    console.log("🔍 Fetching FAQs from:", API_BASE_URL + url);

    sendGet(url)
        .then(response => {
            console.log(" API Response:", response.data);

            if (!Array.isArray(response.data)) {
                console.error("API returned unexpected data format:", response.data);
                return;
            }

            const container = document.getElementById('cardsContainer');
            if (!container) {
                console.error("⚠️ `cardsContainer` not found in DOM! FAQs cannot be displayed.");
                return;
            }

            renderFAQs(response.data);
        })
        .catch(error => {
            console.error("Error fetching FAQs:", error);
        });
}

// Render FAQs
function renderFAQs(faqs) {
    console.log("Rendering FAQs:", faqs);

    if (!Array.isArray(faqs)) {
        console.error("FAQs is not an array:", faqs);
        return;
    }

    const container = document.getElementById('cardsContainer');
    if (!container) {
        console.error("cardsContainer not found in DOM!");
        return;
    }

    container.innerHTML = '';

    faqs.forEach(faq => {
        const faqElem = document.createElement('div');
        faqElem.className = 'faq-card';
        faqElem.innerHTML = `<h3>${faq.question}</h3><p>${faq.answer}</p>`;
        container.appendChild(faqElem);
    });

    console.log("FAQs successfully rendered!");
}

// Filter FAQs
function filterQuestions(e) {
    const query = e.target.value.toLowerCase();
    sendGet("faq.php")
        .then(response => {
            const filteredFAQs = response.data.filter(faq =>
                faq.question.toLowerCase().includes(query) || faq.answer.toLowerCase().includes(query)
            );
            renderFAQs(filteredFAQs);
        })
        .catch(() => console.error("Error filtering FAQs"));
}

// Submit FAQ
function contributeQuestion(e) {
    e.preventDefault();

    const title = document.getElementById("questionTitle").value;
    const body = document.getElementById("questionBody").value;

    if (!title || !body) {
        alert("Please enter a question and an answer.");
        return;
    }

    console.log("Submitting FAQ:", { question: title, answer: body });

    sendPost("faq.php", { question: title, answer: body })
        .then(response => {
            console.log("FAQ Submission Successful:", response.data);
            alert("FAQ added successfully! Redirecting to home...");

            window.location.href = "home.html";
        })
        .catch(error => {
            console.error("FAQ Submission Failed:", error.response ? error.response.data : error);
            alert("Submission failed. Try again.");
        });
}

// Signup Request
function signUpUser(e) {
    e.preventDefault();

    const newUsername = document.getElementById("newUsername").value;
    const email = document.getElementById("email").value;
    const newPassword = document.getElementById("newPassword").value;

    console.log("Submitting signup data:", { action: "signup", username: newUsername, email, password: newPassword });

    sendPost("signup.php", { action: "signup", username: newUsername, email, password: newPassword })
        .then(response => {
            console.log("Signup successful:", response.data);
            localStorage.setItem("loggedIn", "true");
            window.location.href = "home.html";
        })
        .catch(error => {
            console.error("Signup failed:", error.response ? error.response.data : error);
            alert("Signup failed. Try again.");
        });
}

// Login Request
function loginUser(e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    console.log("🔍 Sending login request:", { username, password });

    sendPost("login.php", { action: "login", username, password })
        .then(response => {
            console.log(" Login success:", response.data);

            if (response.data.token) {
                localStorage.setItem("authToken", response.data.token);
                window.location.href = "home.html";
            } else {
                alert("Login failed. Check credentials.");
            }
        })
        .catch(error => {
            console.error("Login error:", error);
            alert("Login failed. Try again.");
        });
}
