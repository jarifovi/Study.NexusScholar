<?php
// FILE: admin_tickets.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Support Ticket Terminal";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-ticket" style="color:var(--primary); margin-right:15px;"></i> Support Ticket Terminal</h1>
    <p>Manage and resolve student inquiries and technical support requests.</p>
</div>

<div class="grid grid-4 mb-4">
    <div class="glass-card stat-card">
        <h3>Open Tickets</h3>
        <p class="stat-value" style="color:var(--accent);">12</p>
    </div>
    <div class="glass-card stat-card">
        <h3>In Progress</h3>
        <p class="stat-value" style="color:var(--secondary);">5</p>
    </div>
    <div class="glass-card stat-card">
        <h3>Resolved Today</h3>
        <p class="stat-value" style="color:var(--primary);">28</p>
    </div>
    <div class="glass-card stat-card">
        <h3>Avg. Response</h3>
        <p class="stat-value">1.4h</p>
    </div>
</div>

<div class="glass-card animate-gravity">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#8842</td>
                    <td>Jarif Ovi</td>
                    <td>Visa rejection clarification</td>
                    <td><span class="badge" style="background:var(--danger);">Urgent</span></td>
                    <td><span class="badge" style="background:var(--accent);">Open</span></td>
                    <td><button class="btn-primary" style="padding:5px 12px; font-size:12px;">Reply</button></td>
                </tr>
                <tr>
                    <td>#8839</td>
                    <td>Adnan Sami</td>
                    <td>SOP Architect loading issue</td>
                    <td><span class="badge" style="background:var(--secondary);">Medium</span></td>
                    <td><span class="badge" style="background:var(--secondary);">In Progress</span></td>
                    <td><button class="btn-primary" style="padding:5px 12px; font-size:12px;">Reply</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
