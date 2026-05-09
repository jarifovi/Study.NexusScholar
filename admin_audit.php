<?php
// FILE: admin_audit.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Admin Activity Audit";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-clipboard-list" style="color:var(--primary); margin-right:15px;"></i> Admin Activity Audit Log</h1>
    <p>A transparent history of all administrative actions performed on the platform.</p>
</div>

<div class="glass-card animate-gravity">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Admin</th>
                    <th>Action</th>
                    <th>Target</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>May 09, 15:24</td>
                    <td><span class="badge" style="background:var(--primary);">SuperAdmin</span></td>
                    <td>Approved Document</td>
                    <td>Jarif Ovi (Passport)</td>
                    <td>192.168.1.45</td>
                </tr>
                <tr>
                    <td>May 09, 14:10</td>
                    <td><span class="badge" style="background:var(--secondary);">SupportTeam</span></td>
                    <td>Published News</td>
                    <td>Global Feed</td>
                    <td>192.168.1.12</td>
                </tr>
                <tr>
                    <td>May 08, 18:45</td>
                    <td><span class="badge" style="background:var(--primary);">SuperAdmin</span></td>
                    <td>Deleted Scholarship</td>
                    <td>Commonwealth (Exp.)</td>
                    <td>192.168.1.45</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="alert warning mt-4">
    <i class="fa-solid fa-shield-halved"></i> <strong>Security Protocol:</strong> Audit logs are read-only and cannot be deleted by any admin level.
</div>

<?php include 'admin_footer.php'; ?>
