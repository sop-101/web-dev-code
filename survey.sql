CREATE TABLE survey (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buong_pangalan VARCHAR(255) NOT NULL,
    edad INT NOT NULL,
    kasarian VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,

    health_status VARCHAR(50),
    chronic_disease TEXT,
    doctor_checkup VARCHAR(20),
    recent_illness VARCHAR(20),

    handwashing VARCHAR(20),
    water_intake VARCHAR(20),
    fruits_vegetables VARCHAR(50),

    smoking VARCHAR(20),
    alcohol VARCHAR(20),
    exercise VARCHAR(50),
    sleep_hours VARCHAR(50),

    stress VARCHAR(20),
    emotional_health VARCHAR(50),
    support_person VARCHAR(20),

    dengue_knowledge VARCHAR(20),
    tb_knowledge VARCHAR(20),
    diabetes_knowledge VARCHAR(20),
    hypertension_knowledge VARCHAR(20),

    health_info_source VARCHAR(100),
    seminar_interest VARCHAR(20),

    suggestions TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
