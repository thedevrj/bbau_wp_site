<?php
/*
Template Name: Alumni Feedback Form
*/

get_header();

$current_user = wp_get_current_user();

$email = !empty($current_user->user_email)
? $current_user->user_email
: '';

$submitted = false;

if(
$_SERVER['REQUEST_METHOD']=='POST'
&&
isset($_POST['submit_feedback'])
){
$submitted=true;
}

?>

<?php get_template_part('template-parts/banner'); ?>
<?php get_template_part('template-parts/breadcrumb'); ?>


<div class="parents-feedback">


    <?php if(!$submitted): ?>


    <!-- HEADER -->

    <div class="pf-header">

        <h1>Alumni Feedback Form</h1>

        <p>
            Babasaheb Bhimrao Ambedkar University, Lucknow-226025
        </p>

    </div>



    <!-- ACCOUNT -->

    <div class="account-box">

        <div>

            <div class="account-mail">

                <i class="fa-solid fa-circle-user"></i>

                <strong>

                    <?php echo esc_html($email); ?>

                </strong>

                <a href="#">

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



        <?php

$text_fields=[

'Name of Alumni',
'Mobile Number',
'e-mail id',
'Association of Department at BBAU',
'Date of Birth',
'Present Organization',
'Designation',
'Present Location'

];

foreach($text_fields as $field):

?>

        <div class="question-card">

            <h3>

                <?php echo $field; ?>

                <span>*</span>

            </h3>


            <input type="text" required name="<?php echo sanitize_title($field); ?>" class="question-input"
                placeholder="Your answer">

        </div>

        <?php endforeach; ?>




        <?php

$questions=[

'Do you feel proud to be associated with BBAU as an Alumni?',

'Institute organizes various kind of activities for overall development of students',

'Are you willing to contribute in the development of the institute?',

'Institute handles student’s grievance properly',

'Institute is having adequate Laboratories and equipment for practical experiences',

'Is education imparted at BBAU useful and relevant in your present job?',

'Have you obtained sufficient technical knowledges both in theory and practical at BBAU?',

'Do you like to join the Institute Alumni Association?',

'Is Institute providing good hospitality as Alumni after passing out?',

'Do you receive regular updates from the Institute through Mails/Calls/SMS/whatsapp etc.?'

];

foreach($questions as $k=>$q):

?>

        <div class="question-card">

            <h3>

                <?php echo $q; ?>

                <span>*</span>

            </h3>


            <label class="radio">

                <input required type="radio" name="q<?php echo $k;?>" value="Strongly Agree">

                Strongly Agree

            </label>


            <label class="radio">

                <input type="radio" name="q<?php echo $k;?>" value="Agree">

                Agree

            </label>


            <label class="radio">

                <input type="radio" name="q<?php echo $k;?>" value="Sometimes">

                Sometimes

            </label>


        </div>

        <?php endforeach; ?>




        <?php

$textarea=[

'Most memorable moment in the Institute',

'Suggestion for improvements of the departments',

'Suggestion for improvements of the institute'

];

foreach($textarea as $area):

?>


        <div class="question-card">

            <h3>

                <?php echo $area; ?>

                <span>*</span>

            </h3>


            <textarea required name="<?php echo sanitize_title($area); ?>" class="question-input"
                placeholder="Your answer">

</textarea>

        </div>


        <?php endforeach; ?>




        <div class="form-action">

            <button class="submit-btn" type="submit" name="submit_feedback">

                Submit

            </button>


            <button type="reset" class="clear-btn">

                Clear form

            </button>

        </div>


        <div class="google-footer">

            <p>

                Never submit passwords through Forms.

            </p>

            <p>

                This form was created outside of your domain.

            </p>

        </div>



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


        <a href="<?php echo get_permalink(); ?>" class="submit-btn">

            Submit another response

        </a>

    </div>


    <?php endif; ?>


</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

/* ===== PAGE ===== */

body{

background:#efeaf7;

font-family:'Inter',sans-serif;

}


.parents-feedback{

max-width:820px;

margin:40px auto;

font-family:'Inter',sans-serif;

}



/* ===== HEADER ===== */

.pf-header{

background:#fff;

padding:42px;

border-radius:12px;

border-top:10px solid #673ab7;

margin-bottom:16px;

box-shadow:0 2px 8px rgba(0,0,0,.06);

}


.pf-header h1{

font-size:32px;

font-weight:600;

color:#202124;

line-height:1.2;

margin-bottom:18px;

letter-spacing:-1px;

}


.pf-header p{

font-size:20px;

color:#5f6368;

font-weight:400;

}



/* ===== ACCOUNT ===== */

.account-box{

background:#fff;

padding:26px 40px;

border-radius:12px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:16px;

}


.account-mail{

display:flex;

align-items:center;

gap:12px;

font-size:18px;

font-weight:600;

color:#202124;

}


.account-mail a{

font: size 16px;px;

font-weight:500;

text-decoration:none;

}


.account-status{

margin-top:12px;

font-size:16px;

color:#5f6368;

}


.draft{

font-size:15px;

color:#5f6368;

}



/* ===== REQUIRED ===== */

.required{

background:#fff;

padding:22px 40px;

border-radius:12px;

font-size:16px;

font-weight:500;

color:#d93025;

margin-bottom:18px;

}



/* ===== QUESTION ===== */

.question-card{

background:#fff;

padding:40px;

margin-bottom:18px;

border-radius:12px;

box-shadow:0 2px 8px rgba(0,0,0,.05);

}


.question-card h3{

font-size:20px;

font-weight:500;

color:#202124;

margin-bottom:35px;

line-height:1.6;

}


.question-card span{

color:#d93025;

}



/* ===== INPUT ===== */

.question-input,

.form-input,

textarea{

width:100%;

border:none;

border-bottom:2px solid #dadce0;

padding:14px 0;

font-size:14px;

font-family:'Inter';

color:#202124;

background:none;

outline:none;

}


.question-input::placeholder,

textarea::placeholder{

color:#80868b;

font-size:14px;

}


.question-input:focus,

textarea:focus{

border-color:#673ab7;

}


textarea{

min-height:90px;

resize:vertical;

}



/* ===== RADIO ===== */

.radio{

display:block;

font-size:16px;

font-weight:400;

margin-bottom:24px;

color:#202124;

cursor:pointer;

}


.radio input{

transform:scale(1.6);

margin-right:18px;

}



/* ===== BUTTON ===== */

.form-action{

display:flex;

justify-content:space-between;

align-items:center;

padding:10px 0 40px;

}


.submit-btn{

background:#673ab7;

color:#fff !important;

border:none;

padding:14px 34px;

border-radius:6px;

font-size:18px;

font-weight:600;

cursor:pointer;

text-decoration:none;

display:inline-block;

}


.submit-btn:hover{

background:#5b30b0;

}


.clear-btn{

background:none;

border:none;

color:#673ab7;

font-size:18px;

font-weight:500;

cursor:pointer;

}



/* ===== SUBMITTED ===== */

.submitted-box{

background:#fff;

padding:80px;

border-radius:12px;

text-align:center;

}


.submitted-box i{

font-size:90px;

color:#34a853;

}


.submitted-box h2{

font-size:42px;

font-weight:600;

margin:20px 0;

}


.submitted-box p{

font-size:20px;

color:#5f6368;

margin-bottom:35px;

}



/* ===== FOOTER ===== */

.google-footer{

text-align:center;

font-size:15px;

color:#5f6368;

padding:40px 0;

line-height:2;

}



/* ===== MOBILE ===== */

@media(max-width:768px){

.parents-feedback{

padding:12px;

}

.pf-header{

padding:30px;

}

.pf-header h1{

font-size:34px;

}

.pf-header p{

font-size:16px;

}

.question-card{

padding:28px;

}

.question-card h3{

font-size:22px;

}

.question-input,

textarea{

font-size:17px;

}

.radio{

font-size:17px;

}

.account-box{

display:block;

}

.form-action{

flex-direction:column;

gap:20px;

}

}
</style>
<?php get_footer(); ?>