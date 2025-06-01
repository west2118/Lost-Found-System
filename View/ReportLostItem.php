<?php
session_start();
$ref_number = isset($_SESSION['ref_number']) ? $_SESSION['ref_number'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Lost Item | Lost & Found</title>
    <link rel="stylesheet" href="../Styles/reportLostItem.css">
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">Lost<span>Found</span></div>
        </header>

        <div class="form-container">
            <div class="progress-bar">
                <div class="progress-line"></div>

                <div class="progress-step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Item Details</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">2</div>
                    <div class="step-label">Contact Info</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Complete</div>
                </div>
            </div>

            <form id="lostItemForm" action="../Controllers/action_report.php" method="POST">
                <div class="step" id="step1">
                    <div class="form-header">
                        <h1>Report Your Lost Item</h1>
                        <p>Fill in the details below to help us identify your lost item</p>
                    </div>

                    <div id="error-message" class="error-message" style="display: none;"></div>
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" id="itemName" name="itemName" class="form-control" placeholder="e.g. iPhone 13, Black Wallet" required>
                    </div>

                    <div class="form-group">
                        <label>Item Category</label>
                        <div class="category-selector">
                            <div class="category-option">
                                <input type="radio" id="electronics" name=itemCategory value="electronics">
                                <label for="electronics">
                                    <span class="icon">📱</span>
                                    Electronics
                                </label>
                            </div>
                            <div class="category-option">
                                <input type="radio" id="wallet" name=itemCategory value="wallet">
                                <label for="wallet">
                                    <span class="icon">💳</span>
                                    Wallet
                                </label>
                            </div>
                            <div class="category-option">
                                <input type="radio" id="keys" name=itemCategory value="keys">
                                <label for="keys">
                                    <span class="icon">🔑</span>
                                    Keys
                                </label>
                            </div>
                            <div class="category-option">
                                <input type="radio" id="bag" name=itemCategory value="bag">
                                <label for="bag">
                                    <span class="icon">🎒</span>
                                    Bag
                                </label>
                            </div>
                            <div class="category-option">
                                <input type="radio" id="jewelry" name=itemCategory value="jewelry">
                                <label for="jewelry">
                                    <span class="icon">💎</span>
                                    Jewelry
                                </label>
                            </div>
                            <div class="category-option">
                                <input type="radio" id="other" name=itemCategory value="other">
                                <label for="other">
                                    <span class="icon">❓</span>
                                    Other
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Provide detailed description including color, size, brand, distinguishing marks, etc." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="dateLost">Date Lost (Approximate)</label>
                        <input type="date" id="dateLost" name="dateLost" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="itemPhoto">Upload Photo (Optional)</label>
                        <input
                            type="url"
                            id="itemPhoto"
                            name="itemPhoto"
                            class="form-control"
                            placeholder="https://example.com/image.jpg" />
                    </div>

                    <div class="form-footer">
                        <a href="/lost&found-system/" class="btn btn-secondary" type="button">Cancel</a>
                        <button type="button" class="btn" id="nextBtn">Next: Contact Info</button>
                    </div>
                </div>


                <div class="step" id="step2" style="display: none;">
                    <div class="form-header">
                        <h1>Your Contact Information</h1>
                        <p>Please provide your details so we can contact you if your item is found</p>
                    </div>

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="fullName" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" name="contactNo" class="form-control" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-footer">
                        <button type="button" id="prevBtn" class="btn btn-secondary" onclick="showStep(1)">Back</button>
                        <button type="submit" id="nextBtn" name="submit" class="btn">Submit Report</button>
                    </div>
                </div>
            </form>


            <div class="step" id="step3" style="display: none;">
                <div class="complete-section">
                    <div class="success-icon">✓</div>
                    <h2>Report Successfully Submitted!</h2>
                    <p>We've received your lost item report. You'll be notified if your item is found.</p>
                    <p>Please check your <strong>email</strong> regularly for any updates regarding your lost item.</p>
                    <p>Your reference number: <strong><?php echo htmlspecialchars($ref_number); ?></strong></p>
                    <a href="/lost&found-system/index.php" class="btn">Back to Homepage</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateStep1() {
            const itemName = document.getElementById('itemName').value.trim();
            const itemCategory = document.querySelector('input[name="itemCategory"]:checked');
            const description = document.getElementById('description').value.trim();
            const dateLost = document.getElementById('dateLost').value.trim();
            const itemPhoto = document.getElementById('itemPhoto').value.trim();

            let errorMsg = '';

            if (itemPhoto && !/^https?:\/\/.*\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(itemPhoto)) {
                errorMsg = 'If provided, the photo URL must be a valid image link (ending in .jpg, .png, etc.)';
            }

            if (!itemName || !itemCategory || !description || !dateLost) {
                errorMsg = 'Please Fill the blanks';
            }

            const errorContainer = document.getElementById('error-message');
            if (errorMsg) {
                errorContainer.textContent = errorMsg;
                errorContainer.style.display = 'block';
                return false;
            } else {
                errorContainer.style.display = 'none';
                return true;
            }
        }

        function getStepFromUrl() {
            const params = new URLSearchParams(window.location.search);
            return parseInt(params.get('step')) || 1;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.progress-step');
            const progressBar = document.querySelector('.progress-line');

            let currentStep = getStepFromUrl(); // Get initial step from URL

            function updateProgress(step) {
                steps.forEach((stepElem, index) => {
                    if (index < step) {
                        stepElem.classList.add('active');
                    } else {
                        stepElem.classList.remove('active');
                    }
                });

                let widthPercent = 0;
                if (step === 1) widthPercent = 5;
                else if (step === 2) widthPercent = 50;
                else if (step === 3) widthPercent = 100;

                if (progressBar) {
                    progressBar.style.width = widthPercent + '%';
                }
            }

            updateProgress(currentStep); // Initialize progress on page load

            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentStep === 1) {
                        const isValid = validateStep1();
                        if (!isValid) return; // Stop if validation fails
                    }

                    if (currentStep < steps.length) {
                        currentStep++;
                        updateProgress(currentStep);
                        showStep(currentStep); // Actually switch the view
                    }
                });
            }


            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentStep > 1) {
                        currentStep--;
                        updateProgress(currentStep);
                    }
                });
            }
        });

        const showStep = (step) => {
            document.querySelectorAll(".step").forEach(div => div.style.display = "none");
            document.getElementById('step' + step).style.display = "block";
        }
    </script>

    <?php if (isset($_GET['submitted'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showStep(3);
            });
        </script>
    <?php endif; ?>
</body>

</html>