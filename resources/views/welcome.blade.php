<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EdTech Platform - Learn Something New</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: transparent !important;
            position: absolute;
            width: 100%;
            z-index: 100;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: white !important;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
        }
        
        .nav-link:hover {
            color: rgba(255,255,255,0.8) !important;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-top: 80px;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .feature-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.2);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-outline-gradient {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-gradient:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }
        
        .stats-item {
            text-align: center;
            padding: 20px;
        }
        
        .stats-number {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .course-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            height: 100%;
            background: white;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
        }
        
        .course-img {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .course-level {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .level-beginner { background: #28a745; color: white; }
        .level-intermediate { background: #ffc107; color: #333; }
        .level-advanced { background: #dc3545; color: white; }
        
        .instructor-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .instructor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #667eea;
            padding: 3px;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            position: relative;
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 60px;
            color: #667eea;
            opacity: 0.2;
            font-family: serif;
        }
        
        footer {
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
        
        @media (max-width: 768px) {
            .welcome-card {
                margin: 20px;
                margin-top: 100px;
            }
            .stats-number {
                font-size: 28px;
            }
            .navbar-brand {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-mortarboard-fill"></i> EdTech
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/courses">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#instructors">Instructors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light" href="/register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Welcome Card -->
                <div class="welcome-card">
                    <div class="card-body p-5 text-center">
                        <h1 class="display-4 fw-bold mb-3">
                            <span class="gradient-text">Learn Something</span><br>
                            <span class="gradient-text">New Every Day</span>
                        </h1>
                        <p class="lead text-muted mb-4">
                            Join thousands of students learning from expert instructors. 
                            Get started with our curated courses today.
                        </p>
                        
                        <div class="d-flex justify-content-center gap-3 mb-5">
                            <a href="/register" class="btn btn-gradient btn-lg px-4">
                                <i class="bi bi-rocket-takeoff"></i> Get Started
                            </a>
                            <a href="/courses" class="btn btn-outline-gradient btn-lg px-4">
                                <i class="bi bi-eye"></i> Browse Courses
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-item">
                                    <div class="stats-number">10K+</div>
                                    <div class="stats-label">Active Students</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-item">
                                    <div class="stats-number">500+</div>
                                    <div class="stats-label">Expert Courses</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-item">
                                    <div class="stats-number">50+</div>
                                    <div class="stats-label">Expert Instructors</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div id="features" class="row g-4 my-5">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <h4>Video Lessons</h4>
                            <p class="text-muted">High-quality video content with lifetime access</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h4>Certificates</h4>
                            <p class="text-muted">Get certified and showcase your skills</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4>Expert Mentors</h4>
                            <p class="text-muted">Learn from industry experts</p>
                        </div>
                    </div>
                </div>

                <!-- 3 Sample Courses -->
                <h2 class="text-center text-white mb-4">Popular Courses</h2>
                <div class="row g-4 mb-5">
                    <!-- Course 1 -->
                    <div class="col-md-4">
                        <div class="course-card">
                            <div class="course-img" style="background-image: url('https://images.unsplash.com/photo-1587620962725-abab7fe55159?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
                                <span class="course-level level-beginner">Beginner</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Web Development Bootcamp</h5>
                                <p class="text-muted small">HTML, CSS, JavaScript, React</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span class="fw-bold">4.9</span>
                                        <small class="text-muted">(2.5k)</small>
                                    </div>
                                    <span class="fw-bold text-primary">৳4,999</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course 2 -->
                    <div class="col-md-4">
                        <div class="course-card">
                            <div class="course-img" style="background-image: url('https://images.unsplash.com/photo-1526379095098-d400fd0bf935?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
                                <span class="course-level level-intermediate">Intermediate</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Python Data Science</h5>
                                <p class="text-muted small">NumPy, Pandas, ML</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span class="fw-bold">4.8</span>
                                        <small class="text-muted">(1.8k)</small>
                                    </div>
                                    <span class="fw-bold text-primary">৳6,499</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course 3 -->
                    <div class="col-md-4">
                        <div class="course-card">
                            <div class="course-img" style="background-image: url('https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
                                <span class="course-level level-advanced">Advanced</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">UI/UX Design</h5>
                                <p class="text-muted small">Figma, Adobe XD</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span class="fw-bold">4.7</span>
                                        <small class="text-muted">(967)</small>
                                    </div>
                                    <span class="fw-bold text-primary">৳5,999</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructor Section -->
                <div id="instructors" class="instructor-section mb-5">
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Instructor" class="instructor-img mb-3">
                            <h4 class="fw-bold">Sherlok Holmes</h4>
                            <p class="text-primary">Senior Web Developer</p>
                        </div>
                        <div class="col-lg-8">
                            <h3 class="gradient-text mb-3">Meet Our Expert Instructors</h3>
                            <p class="lead text-muted">
                                "Our instructors are industry professionals with years of real-world experience. 
                                They're passionate about teaching and dedicated to your success."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="text-center mb-5">
                    <h2 class="text-white mb-4">Ready to Start Learning?</h2>
                    <a href="/register" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-person-plus"></i> Join Now - It's Free!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">© 2026 EdTech Platform. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>