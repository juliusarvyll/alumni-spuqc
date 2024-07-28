<style>
    /* Add keyframes for the slide-in effect */
    /* @keyframes slideInFromLeft {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }
    .hero-left {
        animation: slideInFromLeft 1s ease-out;
    } */

    /* Add hover effect for the button */


    /* Default button styling */
    .btn {
        background-color: #025F1D;
        /* Default background color */
        color: #fff;
        /* Default text color */
        border-radius: 5px;
        /* Rounded corners */
        padding: 1rem 2rem;
        /* Padding */
        margin-top: 1rem;
        /* Top margin */
        transition: background-color 0.3s, box-shadow 0.3s;
        /* Smooth transition for background and shadow */
    }
</style>

<div class="container" style="margin-top: 8rem;">
    <div class="row justify-content-center">
        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-start hero-left">
            <h1 style="font-size: 2.5rem;">Leave a message!</h1>
            <p style="font-size: 1.5rem;">Be part of our community</p>
            <button type="button" class="btn" onclick="uni_modal('Login', 'login.php')">Log In</button>
        </div>
        <div class="col-lg-6">
            <form action="" method="post" style="margin-top: 2rem;">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                        style="font-size: 1.5rem;">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message"
                        style="font-size: 1.5rem;"></textarea>
                </div>
                <button type="submit" class="btn">Send
                    Message</button>

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Ensure the uni_modal function is defined to open the modal
    function uni_modal(title, url) {
        // Example of how you might define this function to load a URL into a modal
        $('#uni_modal .modal-title').text(title);
        $('#uni_modal .modal-body').load(url, function () {
            $('#uni_modal').modal('show');
        });
    }
</script>