@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-speedometer2"></i> Instructor Dashboard</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="/courses/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Course
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Courses</h5>
                <h2 id="totalCourses">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Students</h5>
                <h2 id="totalStudents">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <h2 id="totalRevenue">৳0</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>My Courses</h5>
    </div>
    <div class="card-body">
        <div id="coursesList">
            <!-- Courses will be loaded here -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadInstructorCourses();
});

async function loadInstructorCourses() {
    App.showLoader();
    try {
        const response = await axios.get('/api/courses?instructor=' + App.user.id);
        displayInstructorCourses(response.data.data);
        updateStats(response.data.data);
    } catch (error) {
        App.showToast('Failed to load courses', 'error');
    } finally {
        App.hideLoader();
    }
}

function displayInstructorCourses(courses) {
    const container = document.getElementById('coursesList');
    
    if (courses.length === 0) {
        container.innerHTML = '<p class="text-center">No courses yet. Create your first course!</p>';
        return;
    }

    let html = '<div class="table-responsive"><table class="table">';
    html += '<thead><tr><th>Title</th><th>Price</th><th>Students</th><th>Actions</th></tr></thead><tbody>';

    courses.forEach(course => {
        html += `
            <tr>
                <td>${course.title}</td>
                <td>৳${course.price}</td>
                <td>${course.total_students || 0}</td>
                <td>
                    <a href="/courses/${course.id}" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/courses/${course.id}/edit" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="deleteCourse(${course.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    html += '</tbody></table></div>';
    container.innerHTML = html;
}

function updateStats(courses) {
    let totalStudents = 0;
    let totalRevenue = 0;

    courses.forEach(course => {
        totalStudents += course.total_students || 0;
        totalRevenue += (course.total_students || 0) * course.price;
    });

    document.getElementById('totalCourses').textContent = courses.length;
    document.getElementById('totalStudents').textContent = totalStudents;
    document.getElementById('totalRevenue').textContent = '৳' + totalRevenue;
}

async function deleteCourse(courseId) {
    if (!confirm('Are you sure you want to delete this course?')) return;

    App.showLoader();
    try {
        await axios.delete(`/api/courses/${courseId}`);
        App.showToast('Course deleted successfully', 'success');
        loadInstructorCourses(); // Reload list
    } catch (error) {
        App.showToast('Failed to delete course', 'error');
    } finally {
        App.hideLoader();
    }
}
</script>
@endsection