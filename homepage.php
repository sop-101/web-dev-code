<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brgy 727 Disaster & Health Risk Monitoring System</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        /* ===== NEW SECTIONS CSS ===== */

        /* Community Health Alert Section */
        .health-alert-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 60px 20px;
            color: white;
        }

        .health-alert-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .health-alert-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .health-alert-header h2 {
            font-size: 32px;
            margin: 0;
        }

        .health-alert-header p {
            font-size: 16px;
            opacity: 0.9;
            margin: 5px 0 0 0;
            line-height: 1.6;
        }

        .disease-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .disease-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: transform 0.3s, background 0.3s;
        }

        .disease-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.25);
        }

        .disease-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .disease-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .disease-card h3 {
            margin: 0;
            font-size: 20px;
        }

        .disease-card p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .health-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
            font-size: 14px;
            opacity: 0.8;
        }

        /* Disease Prevention Guide Section */
        .prevention-section {
            background: #f8fafc;
            padding: 60px 20px;
        }

        .prevention-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .prevention-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .prevention-header h2 {
            color: #1e40af;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .prevention-header p {
            color: #64748b;
            font-size: 16px;
        }

        .disease-tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .disease-tab {
            padding: 12px 24px;
            border-radius: 25px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .disease-tab:hover,
        .disease-tab.active {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .prevention-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .prevention-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            border: 2px solid #fecaca;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .prevention-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .prevention-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .prevention-card-header h4 {
            margin: 0;
            color: #1e293b;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .priority-badge {
            background: #dc2626;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .prevention-card p {
            color: #64748b;
            margin: 0;
            line-height: 1.6;
        }

        .prevention-tip {
            background: #eff6ff;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-left: 4px solid #3b82f6;
        }

        .prevention-tip-icon {
            width: 40px;
            height: 40px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }

        .prevention-tip p {
            margin: 0;
            color: #1e40af;
            font-size: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .disease-cards,
            .prevention-cards {
                grid-template-columns: 1fr;
            }

            .health-alert-header h2 {
                font-size: 24px;
            }

            .disease-tabs {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <div class="logo-icon">⚕</div>
                <div class="logo-text">
                    <h1>BRGY 727</h1>
                    <p>Monitoring System</p>
                </div>
            </div>
        </div>

        <!-- LOGIN BUTTONS -->
        <div class="header-right">
            <a href="login_user.php" class="login-btn"><b>USER LOGIN</b></a>
            <a href="login.php" class="login-btn" style="margin-left: 10px;"><b>ADMIN</b></a>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>DISASTER AND RISK<br />MONITORING SYSTEM</h1>
            <p class="hero-subtitle">
                Sagutan ang Survey para sa Iyong Kaligtasan. Ang iyong sagot ay
                makakatulong sa barangay sa oras ng emergency.
            </p>

            <div class="hero-buttons">
                <a href="login_user.php" class="survey-btn">Take Survey</a>
            </div>
        </div>
    </section>

    <!-- ===== NEW: COMMUNITY HEALTH ALERT SECTION ===== -->
    <section class="health-alert-section">
        <div class="health-alert-container">
            <div class="health-alert-header">
                <div class="alert-icon">⚠️</div>
                <div>
                    <h2>Community Health Alert</h2>
                    <p>Protect yourself and your family from common diseases in the Philippines. Early awareness and simple daily habits save lives. Know the risks, take action, and encourage your neighbors.</p>
                </div>
            </div>

            <div class="disease-cards">
                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #8b5cf6;">🦟</div>
                        <h3>Dengue</h3>
                    </div>
                    <p>Eliminate stagnant water weekly. Use the 4S strategy.</p>
                </div>

                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #f59e0b;">💧</div>
                        <h3>Leptospirosis</h3>
                    </div>
                    <p>Avoid wading in floodwater. Wear rubber boots after typhoons.</p>
                </div>

                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #06b6d4;">🌬️</div>
                        <h3>Influenza</h3>
                    </div>
                    <p>Get your annual flu vaccine. Wash hands frequently.</p>
                </div>

                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #10b981;">🌡️</div>
                        <h3>Typhoid</h3>
                    </div>
                    <p>Drink only safe, boiled or bottled water. Practice proper handwashing.</p>
                </div>

                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #6366f1;">🛡️</div>
                        <h3>COVID-19</h3>
                    </div>
                    <p>Stay updated on booster doses. Mask up in crowded indoor spaces.</p>
                </div>

                <div class="disease-card">
                    <div class="disease-card-header">
                        <div class="disease-icon" style="background: #ec4899;">🫁</div>
                        <h3>Tuberculosis</h3>
                    </div>
                    <p>Cough lasting 2+ weeks? Get a free sputum test at your RHU.</p>
                </div>
            </div>

            <div class="health-footer">
                Information based on DOH Philippines and WHO guidelines. Consult your barangay health worker for personalized advice.
            </div>
        </div>
    </section>

    <!-- ===== NEW: DISEASE PREVENTION GUIDE SECTION ===== -->
    <section class="prevention-section">
        <div class="prevention-container">
            <div class="prevention-header">
                <h2>Disease Prevention Guide</h2>
                <p>Select a disease below to view targeted prevention tips you can apply at home and in your community.</p>
            </div>

            <div class="disease-tabs">
                <button class="disease-tab active">🦟 Dengue</button>
                <button class="disease-tab">💧 Leptospirosis</button>
                <button class="disease-tab">🌬️ Influenza</button>
                <button class="disease-tab">🌡️ Typhoid</button>
                <button class="disease-tab">🛡️ COVID-19</button>
                <button class="disease-tab">🫁 Tuberculosis</button>
            </div>

            <div class="prevention-cards">
                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🏺</span> Empty Flower Vases</h4>
                        <span class="priority-badge">Priority</span>
                    </div>
                    <p>Change water daily or remove vases entirely to eliminate mosquito breeding sites.</p>
                </div>

                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🪣</span> Cover Water Containers</h4>
                        <span class="priority-badge">Priority</span>
                    </div>
                    <p>Keep pails, drums, and tanks tightly covered at all times.</p>
                </div>

                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🚰</span> Remove Stagnant Water</h4>
                        <span class="priority-badge">Priority</span>
                    </div>
                    <p>Check for water accumulation in unused items like tires and cans.</p>
                </div>

                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🌧️</span> Clean Gutters & Drains</h4>
                    </div>
                    <p>Prevent water from pooling in roof gutters and drainage channels.</p>
                </div>

                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🧴</span> Use Mosquito Repellent</h4>
                    </div>
                    <p>Apply DEET-based repellent, especially during dawn and dusk.</p>
                </div>

                <div class="prevention-card">
                    <div class="prevention-card-header">
                        <h4><span>🔍</span> Weekly Home Inspection</h4>
                    </div>
                    <p>Inspect your home every week for potential mosquito breeding sites.</p>
                </div>
            </div>

            <div class="prevention-tip">
                <div class="prevention-tip-icon">✓</div>
                <p><strong>Did you know?</strong> Aedes mosquitoes breed in CLEAN, still water. Focus on eliminating any standing water in and around your home.</p>
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="content-container">
            <h2 class="content-title">Kahalagahan ng Kalusugan at Kahandaan</h2>

            <p class="content-paragraph">
                Ang pagiging handa ay mahalaga upang makaiwas sa panganib sa oras ng
                sakuna.
            </p>

            <p class="content-paragraph">
                Sa tamang impormasyon, mas mabilis ang pagresponde ng barangay.
            </p>

            <div class="content-highlight">
                <b>Ang paghahanda ngayon ay pagliligtas bukas.</b>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="hotline-footer">
        <div class="footer-container">
            <h2 class="footer-title">BRGY 727 MONITORING SYSTEM</h2>

            <p class="footer-description">
                Para sa kaligtasan at kahandaan ng bawat residente ng Barangay 727.
            </p>

            <div class="contact-item">Emergency Hotline: 911</div>
            <div class="contact-item">Brgy Hotline: 0917-XXX-XXXX</div>
        </div>
    </footer>

    <div class="bottom-accent"></div>
</body>
</html>
