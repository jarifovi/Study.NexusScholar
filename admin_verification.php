<?php
// FILE: admin_verification.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Verification Terminal";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-file-shield" style="color:var(--primary); margin-right:15px;"></i> Verification Terminal</h1>
    <p>Approve or Reject student document submissions.</p>
</div>

<div class="glass-card animate-gravity">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Document Type</th>
                    <th>File</th>
                    <th>Date Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jarif Ovi</td>
                    <td>Passport</td>
                    <td><a href="#" style="color:var(--primary);"><i class="fa-solid fa-file-pdf"></i> passport_v1.pdf</a></td>
                    <td>May 09, 2026</td>
                    <td>
                        <button class="btn-primary" style="padding:5px 12px; font-size:12px; background:var(--primary);">Approve</button>
                        <button class="btn-primary" style="padding:5px 12px; font-size:12px; background:var(--danger); border-color:var(--danger);">Reject</button>
                    </td>
                </tr>
                <tr>
                    <td>Adnan Sami</td>
                    <td>IELTS TRF</td>
                    <td><a href="#" style="color:var(--primary);"><i class="fa-solid fa-file-pdf"></i> ielts_report.pdf</a></td>
                    <td>May 08, 2026</td>
                    <td>
                        <button class="btn-primary" style="padding:5px 12px; font-size:12px; background:var(--primary);">Approve</button>
                        <button class="btn-primary" style="padding:5px 12px; font-size:12px; background:var(--danger); border-color:var(--danger);">Reject</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
