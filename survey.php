<?php
$basePath = dirname($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="tl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pangkalahatang Pagsusuri sa Kalusugan - BRGY 727</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/survey.css">
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <img src="<?php echo $basePath; ?>/images/HEALTH.PNG" class="logo-icon-img" alt="Health">
                <div class="logo-text">
                    <h1>BRGY 727</h1>
                    <p>HEALTH CAMPAIGN</p>
                </div>
            </div>
        </div>
    </header>

    <!-- SURVEY FORM -->
    <main class="survey-container">
        <form action="submit_survey.php" method="POST" class="survey-form">

            <!-- TITLE SECTION -->
            <div class="survey-header">
                <h1>PANGKAHALATANG PAGSUSURI SA KALUSUGAN</h1>
                <p class="disclaimer">
                    PAALALA: Ang pagsusuri na ito ay ginawa para sa layuning pang-edukasyon at kamalayan lamang. Ang
                    resulta ng survey ay hindi sa mga nakapag na medikal na pagsusuri at hindi dapat ituring na opisyal
                    na diagnosis ng isang lisensyadong doktor.
                </p>
            </div>

            <!-- SECTION I: DIET AND HYDRATION -->
            <div class="section">
                <div class="section-title">I. DIET AND HYDRATION</div>

                <div class="question">
                    <p class="question-text">Question 1: How many servings of fruits and vegetables do you consume on a
                        typical day? (Note: 1 serving = 1 medium fruit or 1 cup of raw leafy greens)</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q1" value="5_or_more"> 5 or more
                            servings</label>
                        <label class="option"><input type="radio" name="q1" value="1_to_4"> 1 to 4 servings</label>
                        <label class="option"><input type="radio" name="q1" value="none"> None</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 2: How frequently do you consume sugar-sweetened beverages like
                        sodas, sweet milk teas, energy drinks, or instant powdered juices?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q2" value="rarely"> Rarely, or less than once a
                            week</label>
                        <label class="option"><input type="radio" name="q2" value="few_times"> A few times over the span
                            of a week</label>
                        <label class="option"><input type="radio" name="q2" value="every_day"> Every single day</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 3: How many glasses of plain water do you drink throughout the
                        day? (Note: 1 glass = approx. 250mL)</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q3" value="8_or_more"> 8 glasses or more</label>
                        <label class="option"><input type="radio" name="q3" value="4_to_7"> 4 to 7 glasses</label>
                        <label class="option"><input type="radio" name="q3" value="3_or_less"> 3 glasses or
                            fewer</label>
                    </div>
                </div>
            </div>

            <!-- SECTION II: DAILY LIFESTYLE AND HABIT -->
            <div class="section">
                <div class="section-title">II. DAILY LIFESTYLE AND HABIT</div>

                <div class="question">
                    <p class="question-text">Question 4: On average, how many days a week do you do at least 30 minutes
                        of moderate-intensity physical activity (such as brisk walking, sweeping, or bicycling)?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q4" value="5_or_more"> 5 or more days</label>
                        <label class="option"><input type="radio" name="q4" value="1_to_4"> 1 to 4 days</label>
                        <label class="option"><input type="radio" name="q4" value="none"> 0 days / None</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 5: How many hours of restful sleep do you manage to get on an
                        average night?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q5" value="7_to_9"> 7 to 9 hours</label>
                        <label class="option"><input type="radio" name="q5" value="6_to_10"> 6 to 10 or more
                            hours</label>
                        <label class="option"><input type="radio" name="q5" value="fewer_6"> Fewer than 6 hours</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 6: Outside of your primary job or school duties, how many hours a
                        day do you spend sitting down looking at screens (TV, mobile phone, or computer)?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q6" value="less_2"> Less than 2 hours</label>
                        <label class="option"><input type="radio" name="q6" value="2_to_4"> 2 to 4 hours</label>
                        <label class="option"><input type="radio" name="q6" value="more_4"> More than 4 hours</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 7: Do you currently use any tobacco products, traditional
                        cigarettes, or e-cigarettes/vapes?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q7" value="never"> No, I have never smoked or
                            used them / I quit completely</label>
                        <label class="option"><input type="radio" name="q7" value="sometimes"> Sometimes / I smoke
                            occasionally or am currently trying to cut back</label>
                        <label class="option"><input type="radio" name="q7" value="daily"> Yes, I use tobacco or vape
                            products on a daily basis</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 8: How often do you consume alcoholic beverages?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q8" value="never"> Never / Rarely (Less than
                            once a month)</label>
                        <label class="option"><input type="radio" name="q8" value="moderately"> Moderately (1 to 2
                            standard drinks a week)</label>
                        <label class="option"><input type="radio" name="q8" value="frequently"> Frequently / Heavily
                            (Multiple times a week or regular heavy drinking sessions)</label>
                    </div>
                </div>
            </div>

            <!-- SECTION III: MENTAL AND PREVENTIVE HEALTH -->
            <div class="section">
                <div class="section-title">III. MENTAL AND PREVENTIVE HEALTH</div>

                <div class="question">
                    <p class="question-text">Question 9: Over the past two weeks, how often have you been bothered by
                        feeling down, depressed, or hopeless, or having little interest or pleasure in doing things?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q9" value="not_at_all"> Not at all /
                            Seldom</label>
                        <label class="option"><input type="radio" name="q9" value="several_days"> Several days across
                            the week</label>
                        <label class="option"><input type="radio" name="q9" value="nearly_every"> Nearly every single
                            day</label>
                    </div>
                </div>

                <div class="question">
                    <p class="question-text">Question 10: When was the last time you had standard health metrics (such
                        as your blood pressure, weight, or blood sugar) checked by a nurse or doctor?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q10" value="past_year"> Within the past
                            year</label>
                        <label class="option"><input type="radio" name="q10" value="1_to_2_years"> 1 to 2 years
                            ago</label>
                        <label class="option"><input type="radio" name="q10" value="more_2_years"> More than 2 years ago
                            / Never</label>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="button-group">
                <button type="submit" class="btn btn-submit">Submit</button>
                <a href="<?php echo $basePath; ?>/homepage.php" class="btn btn-home">Go back Home</a>
                <button type="reset" class="btn btn-clear">Clear</button>
            </div>

        </form>
    </main>
</body>

</html>