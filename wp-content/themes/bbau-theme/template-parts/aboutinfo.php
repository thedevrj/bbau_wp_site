<?php 
/*
Template Name: aboutall 
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg py-lg-5">

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <!-- =====================================
     finance officer SECTION
 ===================================== -->


    <!-- TOP AREA WITH DIFFERENT BACKGROUND -->

    <div class="container">

        <div class="uni-officer-card">

            <div class="uni-officer-top">

                <!-- LEFT IMAGE -->
                <div class="uni-officer-left">
                    <img src="http://localhost:9001/wp-content/uploads/2026/02/finamceofficer.jpg"
                        alt="Finance Officer">
                </div>

                <!-- RIGHT CONTENT -->
                <div class="uni-officer-right">

                    <h3 class="uni-officer-name">
                        Dr. Ajay Kumar Mohanty
                    </h3>

                    <div class="uni-officer-designation">
                        Finance Officer
                    </div>

                    <div class="uni-officer-contact">

                        <p>📞
                            <a class="link-new" href="tel:05222440823">
                                0522-2440823
                            </a>
                        </p>

                        <p>✉
                            <a class="link-new" href="mailto:fo@bbau.ac.in">
                                fo@bbau.ac.in
                            </a>
                        </p>

                        <p>✉
                            <a class="link-new" href="mailto:fobbau@yahoo.com">
                                fobbau@yahoo.com
                            </a>
                        </p>
                    </div>
                    <div class="uni-officer-buttons">
                        <a href="/wp-content/uploads/2026/02/Tenure_Finance_Officer.pdf" class="uni-btn"
                            target="_blank">
                            Tenure of Finance Officer
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>


        <!-- ABOUT SECTION FULL WIDTH (OUTSIDE CARD) -->
        <section class="uni-officer-about">

            <h4>About Finance Section</h4>
            <p>
                Finance Section is one of the main organs of the University and operates as a financial entity to carry
                out financial activities, including proper monitoring and optimum utilization of available funds within
                established financial rules and practices.
            </p>

        </section>
    </div>
</div>
    <style>
    /* ROOT COLORS */
:root{
  --primary:#1a3a6b;
  --primary-dark:#0f2347;
  --accent:#8b1a1a;
  --gold:#c9972a;
  --bg:#ffffff;
  --bg-soft:#f0f4fb;
  --border:#d0daf0;
  --text:#3a3a50;
}


/* TOP WRAPPER */
.uni-officer-top-wrapper{
  background:linear-gradient(135deg,#eef2fb,#f5f7fd,#eef2fb);
  padding:50px 0 60px;
  border-bottom:1px solid var(--border);
  position:relative;
}

.uni-officer-top-wrapper::before{
  content:"";
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:5px;
  background:linear-gradient(to right,var(--primary-dark),var(--primary),var(--gold),var(--accent));
}


/* CARD */
.uni-officer-card{
  background:var(--bg);
  border:1px solid var(--border);
  border-left:4px solid var(--primary);
  border-radius:8px;
  max-width:780px;
  margin:auto;
  box-shadow:0 4px 20px rgba(0,0,0,0.08);
}


/* FLEX TOP */
.uni-officer-top{
  display:flex;
  align-items:center;
  gap: 100px;
  padding:35px 40px;
}


/* IMAGE */
.uni-officer-left{
  position:relative;
}

.uni-officer-left::before{
  content:"";
  position:absolute;
  inset:-5px;
  border-radius:50%;
  background:conic-gradient(var(--primary),var(--gold),var(--accent),var(--primary));
  animation:rotate 8s linear infinite;
}

.uni-officer-left::after{
  content:"";
  position:absolute;
  inset:-2px;
  background:#fff;
  border-radius:50%;
}

.uni-officer-left img{
  width:150px;
  height:150px;
  border-radius:50%;
  object-fit:cover;
  position:relative;
  z-index:1;
}


/* ROTATE ANIMATION */
@keyframes rotate{
  to{transform:rotate(360deg);}
}


/* RIGHT CONTENT */
.uni-officer-right{
  flex:1;
}

.uni-officer-name{
  font-size:24px;
  font-weight:700;
  color:var(--primary-dark);
  margin-bottom:5px;
}

.uni-officer-designation{
  font-size:12px;
  font-weight:600;
  letter-spacing:2px;
  color:var(--accent);
  margin-bottom:15px;
  text-transform:uppercase;
}

.uni-officer-divider-h{
  width:40px;
  height:2px;
  background:var(--primary);
  margin-bottom:15px;
}


/* CONTACT */
.uni-officer-contact{
  margin-bottom:20px;
}

.uni-officer-contact p{
  font-size:14px;
  margin-bottom:6px;
}

.link-new{
  color:var(--primary);
  text-decoration:none;
}

.link-new:hover{
  color:var(--accent);
}


/* BUTTON */
.uni-btn{
  display:inline-block;
  background:var(--primary);
  color:#fff;
  padding:9px 18px;
  font-size:12px;
  text-decoration:none;
  border-radius:3px;
  transition:.3s;
}

.uni-btn:hover{
  background:var(--primary-dark);
}


/* ABOUT SECTION */
.uni-officer-about{
  padding:50px 40px;
  border-top:1px solid var(--border);
  position:relative;
}

.uni-officer-about::after{
  content:"";
  position:absolute;
  bottom:0;
  left:0;
  width:100%;
  height:4px;
  background:linear-gradient(to right,var(--primary-dark),var(--primary),var(--gold),var(--accent));
}

.uni-officer-about h4{
  font-size:26px;
  color:var(--primary-dark);
  margin-bottom:15px;
}

.uni-officer-about p{
  font-size:15px;
  line-height:1.8;
  color:var(--text);
}


/* MOBILE */
@media(max-width:600px){

  .uni-officer-top{
    flex-direction:column;
    text-align:center;
  }

}
    </style>

    <?php get_footer(); ?>