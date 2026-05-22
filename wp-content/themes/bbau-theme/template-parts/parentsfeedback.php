<?php
/*
Template Name: Parents Feedback Form
*/

get_header();

$current_user = wp_get_current_user();

$user_email = !empty($current_user->user_email)
? $current_user->user_email
: 'Guest User';

$submitted = false;

if (
$_SERVER['REQUEST_METHOD'] === 'POST'
&&
isset($_POST['submit_feedback'])
) {

$submitted = true;

}

$questions = [

'The teaching learning environment',

'Competence and commitment of the faculty',

'Provides career oriented programmes',

'Co-curricular activity',

'Physical security in the campus',

'Infrastructure and Transportation facilities',

'Learning sources such as library, Internet and computer',

'Enhancement of student personality',

'Support service like Bank, ATM, Cafeteria and Post Office'

];

?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<?php get_template_part('template-parts/banner'); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>


<div class="container">

    <div class="parents-feedback">


        <?php if(!$submitted): ?>


        <!-- HEADER -->

        <div class="pf-header">

            <h1>

                Parents Feedback Form

            </h1>

            <p>

                Babasaheb Bhimrao Ambedkar University, Lucknow – 226025

            </p>

        </div>



        <!-- ACCOUNT -->

        <div class="account-box">

            <div>

                <div class="account-mail">

                    <i class="fa-solid fa-circle-user"></i>

                    <strong>

                        <?php echo esc_html($user_email); ?>

                    </strong>

                    <a href="<?php echo wp_logout_url(home_url()); ?>">

                        Switch account

                    </a>

                </div>


                <div class="account-status">

                    <i class="fa-regular fa-envelope"></i>

                    Not shared

                </div>

            </div>


            <div class="draft">

                <i class="fa-solid fa-cloud-arrow-up"></i>

                Draft saved

            </div>

        </div>


        <div class="required">

            * Indicates required question

        </div>




        <form method="post">


            <?php foreach($questions as $key=>$question): ?>


            <div class="question-card">

                <h3>

                    <?php echo esc_html($question); ?>

                    <span>*</span>

                </h3>


                <label class="radio">

                    <input required type="radio" name="q_<?php echo $key; ?>" value="Excellent">

                    Excellent

                </label>


                <label class="radio">

                    <input type="radio" name="q_<?php echo $key; ?>" value="Very Good">

                    Very Good

                </label>


                <label class="radio">

                    <input type="radio" name="q_<?php echo $key; ?>" value="Good">

                    Good

                </label>

            </div>


            <?php endforeach; ?>




            <div class="question-card">

                <h3>

                    Any Suggestion

                    <span>*</span>

                </h3>

                <textarea required name="suggestion" placeholder="Your answer">

</textarea>

            </div>




            <button type="submit" name="submit_feedback" class="submit-btn">

                Submit

            </button>


        </form>



        <?php else: ?>


        <div class="submitted-box">

            <i class="fa-solid fa-circle-check"></i>

            <h2>

                Submitted

            </h2>

            <p>

                Your response has been recorded.

                Thank you.

            </p>

            <a href="<?php echo esc_url(get_permalink()); ?>" class="submit-btn">

                Submit another response

            </a>

        </div>


        <?php endif; ?>


    </div>

</div>




<style>
body {

    background: #f3effb;

    font-family: 'Poppins', sans-serif;

}



.parents-feedback {

    max-width: 900px;

    margin: 60px auto;

}



/* HEADER */

.pf-header {

    background: #fff;

    padding: 50px;

    border-top: 12px solid #673ab7;

    border-radius: 18px 18px 0 0;

}

.pf-header h1 {

    font-size: 54px;

    font-weight: 700;

    margin-bottom: 14px;

}

.pf-header p {

    font-size: 22px;

    color: #666;

}



/* ACCOUNT */

.account-box {

    background: #fff;

    padding: 30px 40px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    border-top: 1px solid #eee;

    border-bottom: 1px solid #eee;

}

.account-mail {

    display: flex;

    gap: 10px;

    align-items: center;

    font-size: 18px;

    flex-wrap: wrap;

}

.account-mail i {

    font-size: 28px;

    color: #673ab7;

}

.account-mail strong {

    font-size: 18px;

}

.account-mail a {

    color: #1a73e8;

    text-decoration: none;

    font-weight: 600;

}

.account-status {

    margin-top: 10px;

    color: #666;

}

.draft {

    color: #666;

}



/* REQUIRED */

.required {

    background: #fff;

    padding: 20px 40px;

    color: #d93025;

    font-weight: 600;

    margin-bottom: 24px;

    border-radius: 0 0 18px 18px;

}



/* QUESTION */

.question-card {

    background: #fff;

    padding: 42px;

    margin-bottom: 20px;

    border-radius: 16px;

    box-shadow: 0 4px 20px rgba(0, 0, 0, .04);

}

.question-card h3 {

    font-size: 30px;

    font-weight: 600;

    line-height: 1.5;

    margin-bottom: 35px;

}

.question-card span {

    color: red;

}



/* OPTIONS */

.radio {

    display: flex;

    gap: 16px;

    align-items: center;

    margin-bottom: 22px;

    font-size: 18px;

    font-weight: 500;

    cursor: pointer;

}

.radio input {

    width: 22px;

    height: 22px;

    accent-color: #673ab7;

}



/* TEXTAREA */

textarea {

    width: 100%;

    padding: 16px 0;

    font-size: 18px;

    border: none;

    border-bottom: 2px solid #ddd;

    outline: none;

    font-family: 'Poppins';

}



/* BUTTON */

.submit-btn {

    display: inline-block;

    background: #673ab7;

    color: #fff !important;

    padding: 16px 48px;

    border: none;

    border-radius: 10px;

    font-size: 18px;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    transition: .3s;

}

.submit-btn:hover {

    background: #5327ac;

    color: #fff;

}



/* SUBMITTED */

.submitted-box {

    background: #fff;

    padding: 90px 40px;

    border-radius: 18px;

    text-align: center;

}

.submitted-box i {

    font-size: 90px;

    color: #34a853;

    margin-bottom: 18px;

}

.submitted-box h2 {

    font-size: 50px;

    margin-bottom: 18px;

}

.submitted-box p {

    font-size: 20px;

    margin-bottom: 35px;

    color: #494a4a;

}



/* MOBILE */

@media(max-width:768px) {

    .parents-feedback {

        margin: 30px auto;

    }

    .pf-header {

        padding: 30px;

    }

    .pf-header h1 {

        font-size: 34px;

    }

    .pf-header p {

        font-size: 16px;

    }

    .account-box {

        padding: 24px;

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;

    }

    .question-card {

        padding: 28px;

    }

    .question-card h3 {

        font-size: 22px;

    }

    .radio {

        font-size: 16px;

    }

}
</style>


<?php get_footer(); ?>