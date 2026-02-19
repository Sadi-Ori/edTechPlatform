<!-- resources/views/courses/show.blade.php -->
@extends('layouts.app')

@section('content')
<div id="courseDetail"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCourseDetail();
});

async function loadCourseDetail() {
    App.showLoader();
    const courseId = window.location.pathname.split('/').pop();

    try {
        const response = await axios.get(`/api/courses/${courseId}`);
        displayCourseDetail(response.data.data);
    } catch (error) {
        App.showToast('Failed to load course details', 'error');
    } finally {
        App.hideLoader();
    }
}

function displayCourseDetail(course) {
    const container = document.getElementById('courseDetail');
    
    let html = `
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2>${course.title}</h2>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-${getLevelBadge(course.level)} me-2">${course.level}</span>
                            <div class="rating me-2">${generateStars(course.average_rating)}</div>
                            <span class="text-muted">(${course.reviews?.length || 0} reviews)</span>
                        </div>
                        <p class="lead">${course.description}</p>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h3>৳${course.price}</h3>
                                    <small class="text-muted">One-time payment</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="border rounded p-3">
                                    <h5>Course Includes:</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-play-circle text-primary"></i> ${course.total_lessons} lessons</li>
                                        <li><i class="bi bi-people text-primary"></i> ${course.total_students} students enrolled</li>
                                        <li><i class="bi bi-clock text-primary"></i> Full lifetime access</li>
                                        <li><i class="bi bi-award text-primary"></i> Certificate of completion</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        ${course.is_enrolled ? `
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> You are enrolled in this course
                            </div>
                        ` : App.isAuthenticated && App.userRole === 'student' ? `
                            <button class="btn btn-primary btn-lg w-100" onclick="enrollCourse(${course.id})">
                                <i class="bi bi-cart-plus"></i> Enroll Now
                            </button>
                        ` : ''}
                    </div>
                </div>

                <!-- Lessons -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><i class="bi bi-play-circle"></i> Course Lessons</h4>
                    </div>
                    <div class="list-group list-group-flush">
                        ${course.lessons?.map((lesson, index) => `
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-secondary me-2">${index + 1}</span>
                                        <strong>${lesson.title}</strong>
                                    </div>
                                    ${course.is_enrolled ? `
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewLesson(${lesson.id})">
                                            <i class="bi bi-play"></i> Watch
                                        </button>
                                    ` : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <!-- Reviews -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="bi bi-star"></i> Student Reviews</h4>
                        ${course.is_enrolled && !course.hasReviewed ? `
                            <button class="btn btn-primary" onclick="showReviewForm(${course.id})">
                                Write a Review
                            </button>
                        ` : ''}
                    </div>
                    <div class="card-body">
                        <div id="reviewsList">
                            ${course.reviews?.map(review => `
                                <div class="border-bottom mb-3 pb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>${review.user.name}</strong>
                                            <div class="rating">${generateStars(review.rating)}</div>
                                        </div>
                                        <small class="text-muted">${new Date(review.created_at).toLocaleDateString()}</small>
                                    </div>
                                    <p class="mt-2">${review.comment}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Instructor Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="bi bi-person"></i> Instructor</h5>
                    </div>
                    <div class="card-body">
                        <h5>${course.instructor.name}</h5>
                        <p class="text-muted">${course.instructor.email}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.innerHTML = html;
}

async function enrollCourse(courseId) {
    if (!confirm('Are you sure you want to enroll in this course?')) return;

    App.showLoader();
    try {
        await axios.post(`/api/courses/${courseId}/enroll`);
        App.showToast('Successfully enrolled in course!', 'success');
        loadCourseDetail(); // Reload page
    } catch (error) {
        App.showToast(error.response?.data?.message || 'Enrollment failed', 'error');
    } finally {
        App.hideLoader();
    }
}

function showReviewForm(courseId) {
    const reviewHtml = `
        <div class="modal fade" id="reviewModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Write a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reviewForm">
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select class="form-select" id="rating" required>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Poor</option>
                                    <option value="1">1 - Terrible</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Comment</label>
                                <textarea class="form-control" id="comment" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitReview(${courseId})">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', reviewHtml);
    new bootstrap.Modal(document.getElementById('reviewModal')).show();
}

async function submitReview(courseId) {
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;

    App.showLoader();
    try {
        await axios.post(`/api/courses/${courseId}/reviews`, { rating, comment });
        App.showToast('Review submitted successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('reviewModal')).hide();
        loadCourseDetail(); // Reload to show new review
    } catch (error) {
        App.showToast(error.response?.data?.message || 'Failed to submit review', 'error');
    } finally {
        App.hideLoader();
        document.getElementById('reviewModal').remove();
    }
}
</script>
@endsection