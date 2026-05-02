<?php 
include('db_config.php');

// Ambil data untuk setiap section
// 01
$user_query = mysqli_query($conn, "SELECT * FROM users LIMIT 1");
$user = mysqli_fetch_assoc($user_query);

$file_name = strtolower(str_replace(' ', '_', $user['full_name'])) . ".id";
// 02
$skills_query = mysqli_query($conn, "SELECT * FROM skills ORDER BY proficiency_percent DESC");
// 03
$edu_query = mysqli_query($conn, "SELECT * FROM education ORDER BY id DESC");
// 04
$cert_query = mysqli_query($conn, "SELECT * FROM certificates ORDER BY id DESC");
// 05
$work_query = mysqli_query($conn, "SELECT * FROM work_logs ORDER BY id DESC");
// 06
$projects_query = mysqli_query($conn, "SELECT * FROM projects ORDER BY id DESC");
// 07
$social_query = mysqli_query($conn, "SELECT * FROM social_protocols ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shaka | Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="top-bar">
        <div class="sys-id">
            <span class="pulse"></span>
            <span class="text">SYS_STATUS: OPTIMAL</span>
        </div>
        <nav class="main-nav">
            <a href="#id-panel" class="nav-item">01_IDENTITY</a>
            <a href="#skill-panel" class="nav-item">02_SKILLS</a>
            <a href="#edu-panel" class="nav-item">03_EDUCATION</a>
            <a href="#cert-panel" class="nav-item">04_CERTIFICATES</a>
            <a href="#work-panel" class="nav-item">05_WORK_LOGS</a>
            <a href="#project-panel" class="nav-item">06_PROJECTS</a>
            <a href="#contact-panel" class="nav-item">07_CONNECT</a>
        </nav>
        <div class="time-module" id="clock">00:00:00</div>
    </header>

    <div class="sidebar-left">
        <div class="sidebar-item">DISK: 42%</div>
        <div class="sidebar-item">RAM: 1.2GB</div>
        <div class="sidebar-item">NET: STABLE</div>
    </div>

    <main class="dashboard-wrapper container">
        
        <!-- SECTION 01: IDENTITY -->
        <section id="id-panel" class="panel-box">
            <div class="panel-label">/root/user/<?= $file_name ?></div>
            <div class="panel-content identity-layout">
                <div class="id-header">
                    <h1 class="main-title"><?= strtoupper(htmlspecialchars($user['full_name'])) ?></h1>
                    <p class="sub-title">> <?= strtoupper(htmlspecialchars($user['title'])) ?></p>
                </div>
                <div class="id-details">
                    <div class="terminal-block">
                        <p class="code-line"><span class="cmd">shaka@debeast:~$</span> fetch-profile --brief</p>
                        <p class="res"><?= htmlspecialchars($user['bio']) ?></p>
                        
                        <p class="code-line"><span class="cmd">shaka@debeast:~$</span> get-location</p>
                        <p class="res"><?= htmlspecialchars($user['location']) ?></p>
                        
                        <p class="code-line"><span class="cmd">shaka@debeast:~$</span> system-check</p>
                        <p class="res">
                            Hardware: <?= htmlspecialchars($user['hardware_info']) ?> | 
                            OS: <?= htmlspecialchars($user['os_info']) ?> | 
                            Kernel: <?= htmlspecialchars($user['kernel_info']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 02: SKILLS (DYNAMIC) -->
        <section id="skill-panel" class="panel-box">
            <div class="panel-label">core_capabilities.metrics</div>
            <div class="panel-content">
                <?php while($skill = mysqli_fetch_assoc($skills_query)): ?>
                <div class="skill-row">
                    <div class="skill-head">
                        <span><?= strtoupper(htmlspecialchars($skill['skill_name'])) ?></span>
                        <span><?= $skill['proficiency_percent'] ?>%</span>
                    </div>
                    <div class="progress-container">
                        <!-- Data-width digunakan oleh JavaScript untuk animasi loading bar -->
                        <div class="bar-fill" data-width="<?= $skill['proficiency_percent'] ?>%"></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- SECTION 03: EDUCATION (DYNAMIC) -->
        <section id="edu-panel" class="panel-box">
            <div class="panel-label">academic_records.db</div>
            <div class="panel-content">
                <?php 
                $count = 0;
                while($edu = mysqli_fetch_assoc($edu_query)): 
                    $count++;
                    $divider_class = ($count > 1) ? 'divider' : '';
                ?>
                <div class="edu-card <?= $divider_class ?>">
                    <div class="edu-header">
                        <div class="edu-year"><?= strtoupper(htmlspecialchars($edu['period'])) ?></div>
                        <h3 class="edu-inst"><?= strtoupper(htmlspecialchars($edu['institution'])) ?></h3>
                    </div>
                    <p class="edu-major"><?= htmlspecialchars($edu['major']) ?></p>
                    
                    <div class="edu-details">
                        <?php 
                        $edu_id = $edu['id'];
                        $details_query = mysqli_query($conn, "SELECT * FROM education_details WHERE education_id = $edu_id");
                        while($detail = mysqli_fetch_assoc($details_query)): 
                        ?>
                        <p>> <?= htmlspecialchars($detail['description_point']) ?></p>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- SECTION 04: CERTIFICATES (DYNAMIC) -->
        <section id="cert-panel" class="panel-box">
            <div class="panel-label">authorized_certificates.json</div>
            <div class="panel-content cert-grid">
                <?php while($cert = mysqli_fetch_assoc($cert_query)): ?>
                <div class="cert-item">
                    <!-- cert_date digunakan sebagai kode unik visual -->
                    <div class="cert-code"><?= strtoupper(htmlspecialchars($cert['cert_date'])) ?></div>
                    <div class="cert-info">
                        <h4><?= htmlspecialchars($cert['cert_name']) ?></h4>
                        <p><?= htmlspecialchars($cert['issuer']) ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- SECTION 05: WORK LOGS (DYNAMIC) -->
        <section id="work-panel" class="panel-box">
            <div class="panel-label">employment_history.log</div>
            <div class="panel-content">
                <div class="work-log-container">
                    <?php while($work = mysqli_fetch_assoc($work_query)): 
                        // Logika untuk menambahkan class 'active' pada status tertentu
                        $status_class = ($work['status'] == 'IN_PROGRESS' || $work['status'] == 'ACTIVE') ? 'active' : '';
                    ?>
                    <div class="work-entry">
                        <div class="work-meta">
                            <span class="work-date">[<?= strtoupper(htmlspecialchars($work['period'])) ?>]</span>
                            <span class="work-status <?= $status_class ?>"><?= strtoupper(htmlspecialchars($work['status'])) ?></span>
                        </div>
                        <div class="work-body">
                            <h3 class="work-role"><?= strtoupper(htmlspecialchars($work['role'])) ?></h3>
                            <p class="work-company"><?= htmlspecialchars($work['company_project']) ?></p>
                            <ul class="work-tasks">
                                <?php 
                                $work_id = $work['id'];
                                $details_query = mysqli_query($conn, "SELECT * FROM work_details WHERE work_id = $work_id");
                                while($detail = mysqli_fetch_assoc($details_query)): 
                                ?>
                                <li><?= htmlspecialchars($detail['description_point']) ?></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 06: PROJECTS (DYNAMIC) -->
        <section id="project-panel" class="panel-box">
            <div class="panel-label">active_projects_bin.exe</div>
            <div class="panel-content proj-container">
                <?php while($proj = mysqli_fetch_assoc($projects_query)): 
                    $status_raw = strtoupper($proj['status']);
                    $status_class = (strpos($status_raw, 'DEV') !== false) ? 'dev' : '';
                ?>
                <div class="proj-card">
                    <div class="proj-header">
                        <h3><?= strtoupper(htmlspecialchars($proj['project_name'])) ?></h3>
                        <span class="p-status <?= $status_class ?>"><?= $status_raw ?></span>
                    </div>
                    <p><?= htmlspecialchars($proj['description']) ?></p>
                    <div class="p-footer"><?= strtoupper(htmlspecialchars($proj['tech_stack'])) ?></div>
                    
                    <?php if(!empty($proj['url'])): ?>
                        <a href="<?= $proj['url'] ?>" target="_blank" style="font-size: 0.8rem; color: var(--primary-color); text-decoration: none; margin-top: 5px; display: inline-block;">
                            > ACCESS_LINK
                        </a>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- SECTION 07: MESSAGE TERMINAL -->
        <section id="contact-panel" class="panel-box">
            <div class="panel-label">transmit_payload.exe</div>
            <div class="panel-content">
                <div class="terminal-header">
                    <h2 class="terminal-title">SEND_MESSAGE</h2>
                    <p class="contact-desc">Gunakan protokol di bawah ini untuk mengirimkan transmisi data langsung ke penerima.</p>
                </div>
                
                <form id="contact-form" class="sys-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>SENDER_ID</label>
                            <input type="text" name="sender_id" placeholder="Name / Alias" required>
                        </div>
                        <div class="form-group">
                            <label>RETURN_PATH</label>
                            <input type="email" name="return_path" placeholder="email@domain.com" required>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <label>DATA_STREAM</label>
                        <textarea name="data_stream" rows="6" placeholder="Awaiting input..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn" id="send-btn">
                        <span class="btn-text">EXECUTE_TRANSMISSION</span>
                    </button>
                </form>
                <div id="form-status" class="form-response" style="margin-top: 15px; font-family: monospace;"></div>
            </div>
        </section>

        <script>
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('send-btn');
            const status = document.getElementById('form-status');
            const formData = new window.FormData(e.target);

            btn.disabled = true;
            status.innerText = "> INITIALIZING_CONNECTION...";

            fetch('send_message.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                status.innerText = "> " + data;
                if(data.includes("SUCCESS")) {
                    this.reset();
                }
                btn.disabled = false;
            })
            .catch(error => {
                status.innerText = "> ERROR: CONNECTION_TIMEOUT";
                btn.disabled = false;
            });
        });
        </script>

        <!-- SECTION 08: SOCIAL_PROTOCOLS -->
        <section id="social-panel" class="panel-box">
            <div class="panel-label">external_links.sys</div>
            <div class="panel-content">
                <div class="social-grid">
                    <?php while($social = mysqli_fetch_assoc($social_query)): ?>
                    <a href="<?= htmlspecialchars($social['url']) ?>" class="social-item" target="_blank">
                        <span class="soc-label"><?= strtoupper(htmlspecialchars($social['platform_name'])) ?></span>
                        <span class="soc-val"><?= htmlspecialchars($social['display_value']) ?></span>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-sys">
        <div class="container">
            <div class="footer-grid">
                <div class="f-item">OS_TYPE: DEBEAST_UI_V4</div>
                <div class="f-item">ENCODING: UTF-8</div>
                <div class="f-item">© 2026 SHAKA BANUASTA. NO_RIGHTS_RESERVED.</div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>