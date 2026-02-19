<!-- resources/views/courses/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-book"></i> Available Courses</h2>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->check() && (auth()->user()->role === 'instructor' || auth()->user()->role === 'admin'))
        <a href="/courses/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Course
        </a>
        @endif
    </div>
</div>

<!-- Search and Filter -->
<div class="row mb-4">
    <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
    </div>
    <div class="col-md-3">
        <select id="levelFilter" class="form-select">
            <option value="">All Levels</option>
            <option value="beginner">Beginner</option>
            <option value="intermediate">Intermediate</option>
            <option value="advanced">Advanced</option>
        </select>
    </div>
    <div class="col-md-3">
        <select id="sortFilter" class="form-select">
            <option value="created_at,desc">Newest First</option>
            <option value="created_at,asc">Oldest First</option>
            <option value="price,asc">Price: Low to High</option>
            <option value="price,desc">Price: High to Low</option>
            <option value="title,asc">Title: A to Z</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100" onclick="loadCourses()">
            <i class="bi bi-search"></i> Search
        </button>
    </div>
</div>

<!-- Courses Grid -->
<div id="coursesContainer" class="row row-cols-1 row-cols-md-3 g-4">
    <!-- Courses will be loaded here via AJAX -->
</div>

<!-- Pagination -->
<div id="pagination" class="d-flex justify-content-center mt-4"></div>

<script>
let currentPage = 1;

document.addEventListener('DOMContentLoaded', function() {
    loadCourses();
    
    // Auto-search on filter change
    document.getElementById('levelFilter').addEventListener('change', loadCourses);
    document.getElementById('sortFilter').addEventListener('change', loadCourses);
});

async function loadCourses(page = 1) {
    App.showLoader();
    currentPage = page;
    
    const search = document.getElementById('searchInput')?.value || '';
    const level = document.getElementById('levelFilter')?.value || '';
    const sort = document.getElementById('sortFilter')?.value || 'created_at,desc';
    const [sortBy, sortOrder] = sort.split(',');

    try {
        console.log('Loading courses...'); // Debug log
        const response = await axios.get('/api/courses', {
            params: {
                page,
                search,
                level,
                sort_by: sortBy,
                sort_order: sortOrder,
                per_page: 9
            }
        });
        
        console.log('Courses loaded:', response.data); // Debug log
        displayCourses(response.data.data);
        displayPagination(response.data.meta);
    } catch (error) {
        console.error('Error loading courses:', error); // Debug log
        App.showToast(error.response?.data?.message || 'Failed to load courses', 'error');
        
        // Fallback: show empty state
        document.getElementById('coursesContainer').innerHTML = `
            <div class="col-12 text-center py-5">
                <h4>No courses found</h4>
                <p class="text-muted">Check back later for new courses</p>
            </div>
        `;
    } finally {
        App.hideLoader();
    }
}

function displayCourses(courses) {
    const container = document.getElementById('coursesContainer');
    
    if (courses.length === 0) {
        container.innerHTML = '<div class="col-12 text-center py-5"><h4>No courses found</h4></div>';
        return;
    }

    let html = '';
    courses.forEach(course => {
        html += `
            <div class="col">
                <div class="card h-100 course-card">
                    <div class="card-body">
                        <span class="badge bg-${getLevelBadge(course.level)} mb-2">${course.level}</span>
                        <h5 class="card-title">${course.title}</h5>
                        <p class="card-text">${course.description.substring(0, 100)}...</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="h5 mb-0">৳${course.price}</span>
                            <div class="rating">
                                ${generateStars(course.average_rating)}
                                <small class="text-muted">(${course.reviews_count || 0})</small>
                            </div>
                        </div>
                        <div class="text-muted small mb-2">
                            <i class="bi bi-person"></i> ${course.instructor.name}
                            <span class="mx-2">|</span>
                            <i class="bi bi-play-circle"></i> ${course.total_lessons} lessons
                            <span class="mx-2">|</span>
                            <i class="bi bi-people"></i> ${course.total_students} students
                        </div>
                        <a href="/courses/${course.id}" class="btn btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

function getLevelBadge(level) {
    const badges = {
        'beginner': 'success',
        'intermediate': 'warning',
        'advanced': 'danger'
    };
    return badges[level] || 'secondary';
}

function generateStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= Math.floor(rating)) {
            stars += '<i class="bi bi-star-fill"></i>';
        } else if (i - rating < 1 && i - rating > 0) {
            stars += '<i class="bi bi-star-half"></i>';
        } else {
            stars += '<i class="bi bi-star"></i>';
        }
    }
    return stars;
}

function displayPagination(meta) {
    if (!meta || meta.last_page <= 1) return;

    let html = '<nav><ul class="pagination">';
    
    // Previous button
    html += `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadCourses(${meta.current_page - 1})">Previous</a>
    </li>`;

    // Page numbers
    for (let i = 1; i <= meta.last_page; i++) {
        html += `<li class="page-item ${meta.current_page === i ? 'active' : ''}">
            <a class="page-link" href="#" onclick="loadCourses(${i})">${i}</a>
        </li>`;
    }

    // Next button
    html += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadCourses(${meta.current_page + 1})">Next</a>
    </li>`;

    html += '</ul></nav>';
    document.getElementById('pagination').innerHTML = html;
}
</script>
@endsection