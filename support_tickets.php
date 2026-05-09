<?php
// FILE: support_tickets.php
require_once 'auth_check.php';

$page_title = "Support Tickets";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-headset" style="color:var(--primary); margin-right:15px;"></i> Support & Inquiries</h1>
    <p>Need help with your application? Open a ticket and our team will assist you.</p>
</div>

<div class="grid grid-3">
    <!-- NEW TICKET -->
    <div class="glass-card animate-gravity delay-1 grid-col-span-2">
        <h2><i class="fa-solid fa-plus"></i> Open New Ticket</h2>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" placeholder="Briefly describe your issue">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select>
                <option>Technical Issue</option>
                <option>Document Verification</option>
                <option>Visa Counseling</option>
                <option>Scholarship Inquiry</option>
                <option>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea rows="5" placeholder="Explain your situation in detail..."></textarea>
        </div>
        <button class="btn-primary" onclick="alert('Ticket submitted successfully!')">Submit Request</button>
    </div>

    <!-- MY TICKETS -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-clock-rotate-left"></i> My Tickets</h2>
        <div class="ticket-status-item">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span class="badge" style="background:var(--accent);">Open</span>
                <span style="font-size:11px; color:var(--text-muted);">#8842</span>
            </div>
            <h4 style="margin:0;">Visa rejection clarification</h4>
            <p style="font-size:12px; color:var(--text-dim); margin-top:5px;">Last updated: 1 hour ago</p>
        </div>
    </div>
</div>

<style>
.ticket-status-item {
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    margin-bottom: 15px;
}
</style>

<?php include 'footer.php'; ?>
