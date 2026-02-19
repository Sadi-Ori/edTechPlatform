@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="bi bi-collection"></i> My Enrolled Courses</h2>
    </div>
</div>

<div id="enrolledCourses" class="row row-cols-1 row-cols-md-3 g-4">
    <!-- Courses will be loaded here -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadMyCourses();
});

async function loadMyCourses() {
    App.showLoader();
    try {
        const response = await axios.get('/api/my-courses');
        displayMyCourses(response.data.data);
    } catch (error) {
        App.showToast('Failed to load courses', 'error');
    } finally {
        App.hideLoader();
    }
}

function displayMyCourses(courses) {
    const container = document.getElementById('enrolledCourses');
    
    if (courses.length === 0) {
        container.innerHTML = '<div class="col-12 text-center py-5"><h4>You haven\'t enrolled in any courses yet</h4><a href="/courses" class="btn btn-primary mt-3">Browse Courses</a></div>';
        return;
    }

    let html = '';
    courses.forEach(course => {
        html += `
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-${getLevelBadge(course.level)} mb-2">${course.level}</span>
                        <h5 class="card-title">${course.title}</h5>
                        <p class="card-text">${course.description.substring(0, 100)}...</p>
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> ${course.instructor.name}
                            </small>
                        </div>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: ${course.progress || 0}%"></div>
                        </div>
                        <small class="text-muted">Enrolled: ${new Date(course.pivot.enrolled_at).toLocaleDateString()}</small>
                        <a href="/courses/${course.id}" class="btn btn-outline-primary w-100 mt-3">
                            Continue Learning
                        </a>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}
</script>
@endsection