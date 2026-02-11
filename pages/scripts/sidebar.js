$(document).ready(function() {
    
    // Toggle Sidebar
    $(".sidebar-toggle").click(function() {
        $(".dashboard-wrapper").toggleClass("toggled");
    });

    // Logout Modal Trigger
    $("#logoutBtn").click(function(e) {
        e.preventDefault();
        const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        logoutModal.show();
    });

});