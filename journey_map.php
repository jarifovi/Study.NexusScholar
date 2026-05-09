<?php
// FILE: journey_map.php
require_once 'auth_check.php';

$page_title = "Journey Map";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-map-location-dot" style="color:var(--primary); margin-right:15px;"></i> Academic Journey Map</h1>
    <p>Visualize your path from preparation to graduation.</p>
</div>

<div class="glass-card animate-gravity delay-1 overflow-x-auto" style="padding: 0;">
    <div class="journey-timeline">
        <div class="timeline-line"></div>
        
        <div class="timeline-nodes">
            <!-- Node 1 -->
            <div class="timeline-node active">
                <div class="node-icon"><i class="fa-solid fa-file-invoice"></i></div>
                <div class="node-content">
                    <h4>Preparation</h4>
                    <p>Current Phase: Document collection & CGPA tracking.</p>
                    <span class="node-date">May 2026 - Aug 2026</span>
                </div>
            </div>

            <!-- Node 2 -->
            <div class="timeline-node">
                <div class="node-icon"><i class="fa-solid fa-building-columns"></i></div>
                <div class="node-content">
                    <h4>Applications</h4>
                    <p>Shortlisting universities & submitting applications.</p>
                    <span class="node-date">Sept 2026 - Dec 2026</span>
                </div>
            </div>

            <!-- Node 3 -->
            <div class="timeline-node">
                <div class="node-icon"><i class="fa-solid fa-passport"></i></div>
                <div class="node-content">
                    <h4>Visa Process</h4>
                    <p>Interview preparation & visa submission.</p>
                    <span class="node-date">Jan 2027 - Mar 2027</span>
                </div>
            </div>

            <!-- Node 4 -->
            <div class="timeline-node">
                <div class="node-icon"><i class="fa-solid fa-plane-arrival"></i></div>
                <div class="node-content">
                    <h4>Enrollment</h4>
                    <p>Flying to target country & orientation week.</p>
                    <span class="node-date">Aug 2027 - Sept 2027</span>
                </div>
            </div>

            <!-- Node 5 -->
            <div class="timeline-node highlight">
                <div class="node-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="node-content">
                    <h4>Graduation</h4>
                    <p>The final goal: Degree attainment & Career start.</p>
                    <span class="node-date">May 2031</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.journey-timeline {
    position: relative;
    padding: 60px 100px; /* Add horizontal padding to prevent cutoffs */
    min-width: 1300px;
}

.timeline-line {
    position: absolute;
    top: 100px; /* Adjusted for perfect vertical center */
    left: 100px;
    right: 100px;
    height: 4px;
    background: rgba(255,255,255,0.05);
    z-index: 1;
}

.timeline-nodes {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.timeline-node {
    width: 200px;
    text-align: center;
    position: relative;
}

.node-icon {
    width: 80px;
    height: 80px;
    background: var(--bg-card);
    border: 2px solid var(--border-glass);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--text-dim);
    margin: 0 auto 30px;
    transition: var(--transition);
}

.timeline-node.active .node-icon {
    border-color: var(--primary);
    color: var(--primary);
    box-shadow: 0 0 30px var(--primary-glow);
    background: rgba(16,185,129,0.1);
}

.timeline-node.highlight .node-icon {
    border-color: var(--accent);
    color: var(--accent);
    box-shadow: 0 0 30px rgba(251,191,36,0.2);
}

.node-content h4 {
    margin-bottom: 10px;
    color: #fff;
    font-size: 18px;
}

.node-content p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 10px;
}

.node-date {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--primary);
    font-weight: 700;
}
</style>

<?php include 'footer.php'; ?>
