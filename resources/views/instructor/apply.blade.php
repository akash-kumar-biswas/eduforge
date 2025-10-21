<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Instructor - EduForge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #04317aff;
            --primary-dark: #02234f;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f2f2f5ff 0%, #ecebedff 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .application-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .application-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .application-header {
            background: white;
            color: var(--text-dark);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 2px solid var(--border);
        }

        .application-header .logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .application-header .logo i {
            font-size: 28px;
            color: white;
        }

        .application-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .application-header p {
            color: var(--text-muted);
            font-size: 15px;
        }

        .application-body {
            padding: 40px 30px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-label .required {
            color: #dc2626;
            margin-left: 3px;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(4, 49, 122, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .file-upload {
            position: relative;
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: block;
            padding: 12px 14px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background: rgba(4, 49, 122, 0.05);
        }

        .file-upload-label i {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .btn-submit {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .btn-back:hover {
            color: var(--primary);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            border: none;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 768px) {
            .application-body {
                padding: 30px 20px;
            }

            .application-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="application-container">
        <a href="{{ route('instructor.login') }}" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i>Back to Login
        </a>

        <div class="application-card">
            <!-- Header -->
            <div class="application-header">
                <div class="logo">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h1>Apply as Instructor</h1>
                <p>Join our community of expert educators and share your knowledge</p>
            </div>

            <!-- Body -->
            <div class="application-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('instructor.apply.submit') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="section-title">Personal Information</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address<span class="required">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number<span class="required">*</span></label>
                                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Country<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="country" value="{{ old('country') }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="form-section">
                        <h3 class="section-title">Professional Information</h3>

                        <div class="form-group">
                            <label class="form-label">Expertise/Subject Area<span class="required">*</span></label>
                            <input type="text" class="form-control" name="expertise"
                                placeholder="e.g., Web Development, Data Science, Digital Marketing"
                                value="{{ old('expertise') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Years of Experience<span class="required">*</span></label>
                            <select class="form-select" name="experience" required>
                                <option value="">Select experience level</option>
                                <option value="0-2" {{ old('experience') == '0-2' ? 'selected' : '' }}>0-2 years</option>
                                <option value="3-5" {{ old('experience') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                                <option value="6-10" {{ old('experience') == '6-10' ? 'selected' : '' }}>6-10 years
                                </option>
                                <option value="10+" {{ old('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Why do you want to teach at EduForge?<span
                                    class="required">*</span></label>
                            <textarea class="form-control" name="motivation" required>{{ old('motivation') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Brief Bio / Teaching Philosophy</label>
                            <textarea class="form-control" name="bio">{{ old('bio') }}</textarea>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="form-section">
                        <h3 class="section-title">Supporting Documents</h3>

                        <div class="form-group">
                            <label class="form-label">Upload CV/Resume<span class="required">*</span></label>
                            <div class="file-upload">
                                <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
                                <div class="file-upload-label">
                                    <i class="bi bi-cloud-upload d-block"></i>
                                    <span>Click to upload your CV (PDF, DOC, DOCX - Max 5MB)</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">LinkedIn Profile URL</label>
                            <input type="url" class="form-control" name="linkedin"
                                placeholder="https://www.linkedin.com/in/yourprofile" value="{{ old('linkedin') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Portfolio/Website URL</label>
                            <input type="url" class="form-control" name="portfolio"
                                placeholder="https://yourportfolio.com" value="{{ old('portfolio') }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send me-2"></i>Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>