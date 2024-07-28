<div class="container" style="margin-top: 8rem;">
    <div class="row justify-content-center">
        <div class="col-lg-5 d-flex flex-column justify-content-center align-items-start hero-left" style="margin-right: 5rem;">
            <h1 style="font-size: 3rem;">Get in touch!</h1>
            <p>Stay connected, SPUQC alumni! Share your insights or get in touch for any inquiries.</p>       
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
                <button type="submit" class="btn"
                    style="background-color: #005b00; color:white; border-radius: 5px; padding: 1rem 2rem; ">Send
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