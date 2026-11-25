<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$profile = getProfile($pdo);
$settings = getSettings($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nitish Yadav — Creative Developer & Designer</title>
    <meta name="description"
        content="Portfolio of Nitish Kumar Yadav, a creative full-stack developer and UI/UX designer crafting digital experiences.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/home.css">
</head>

<body class="relative">

    <!-- Background decoration -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="fixed inset-0 grid-pattern pointer-events-none z-0"></div>

    <!-- ============ NAVBAR ============ -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="glass border-b border-white/5">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="#home" class="flex items-center gap-2 group">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center font-display font-bold text-black  group-hover:rotate-12 transition-transform">
                        NKY
                    </div>
                    <span class="font-display font-bold text-xl tracking-tight"><?php echo $profile['name']; ?><span
                            class="gradient-text">.</span></span>
                </a>

                <div class="hidden lg:flex items-center gap-8 text-sm">
                    <a href="#home" class="nav-link active">Home</a>
                    <a href="#about" class="nav-link">About</a>
                    <a href="#services" class="nav-link">Services</a>
                    <a href="#skills" class="nav-link">Skills</a>
                    <a href="#projects" class="nav-link">Work</a>
                    <a href="#experience" class="nav-link">Journey</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="#contact"
                        class="hidden md:flex btn-primary px-5 py-2.5 rounded-full text-sm items-center gap-2">
                        <span>Let's Talk</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <button id="menuBtn"
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full glass">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-xl"></div>
        <div class="relative h-full flex flex-col items-center justify-center gap-6 text-2xl font-display">
            <button id="closeMenu"
                class="absolute top-6 right-6 w-12 h-12 rounded-full glass flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <a href="#home" class="mobile-link">Home</a>
            <a href="#about" class="mobile-link">About</a>
            <a href="#services" class="mobile-link">Services</a>
            <a href="#skills" class="mobile-link">Skills</a>
            <a href="#projects" class="mobile-link">Work</a>
            <a href="#experience" class="mobile-link">Journey</a>
            <a href="#contact" class="mobile-link">Contact</a>
        </div>
    </div>

    <!-- ============ HERO ============ -->
    <section id="home" class="relative min-h-screen flex items-center pt-24 pb-12 z-10">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-6">
                        <span class="pulse-dot w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-sm text-gray-300">Welcome to my portfolio</span>
                    </div>

                    <h1 class="font-display font-bold tracking-tight mb-6" style="font-size:clamp(2.5rem,7vw,2.5rem);">
                        Hey, I'm <span class="text-[#ff6b35]"><?php echo $profile['name']; ?></span><br>
                        <!-- <span class="gradient-text">Creative</span><br> -->
                        <span class=" typed-text"></span>
                    </h1>

                    <p class="text-lg md:text-xl text-gray-400 max-w-2xl mb-8 leading-relaxed">
                        <?php echo $profile['title']; ?>
                        <!-- I craft <span class="text-white font-medium">digital experiences</span> that blend strategy, design, and
            code.
            Specializing in <span class="text-[#ff6b35]">full-stack development</span> and
            <span class="text-[#ffb627]">UI/UX design</span> for ambitious brands. -->
                    </p>

                    <div class="flex flex-wrap gap-4 mb-12">
                        <a href="#projects" class="btn-primary px-7 py-3.5 rounded-full inline-flex items-center gap-2">
                            <span>View My Work</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="#contact"
                            class="glass px-7 py-3.5 rounded-full inline-flex items-center gap-2 hover:bg-white/5 transition">
                            <i class="fa-solid fa-paper-plane text-[#ff6b35]"></i>
                            <span>Get In Touch</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-6">
                        <span class="text-sm text-gray-500 mono">Follow →</span>
                        <div class="flex gap-3">


                            <!-- <?php if (!empty($profile['github'])): ?>
                                <a href="<?php echo htmlspecialchars($profile['github']); ?>"
                                  class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                  class="fa-brands fa-github"></i></a><?php endif; ?> -->

                            <?php if (!empty($profile['github'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1">
                                <i class="fa-brands fa-github"></i>
                            </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-linkedin-in"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-facebook"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-twitter"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['instagram']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-instagram"></i></a> <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 relative">
                    <div class="relative max-w-md mx-auto">
                        <!-- Decorative ring -->
                        <div
                            class="absolute -inset-4 rounded-full bg-gradient-to-tr from-[#ff6b35] via-[#ffb627] to-[#00d9ff] opacity-30 blur-2xl">
                        </div>

                        <div class="relative aspect-square rounded-[2rem] overflow-hidden glass p-2 floating">
                            <!-- <img src="nitish.png" alt="Nitish Yadav"
                class="w-full h-full object-cover rounded-[1.7rem]"> -->
                            <img src="assets/images/profile/<?php echo $profile['profile_image'] ?? 'default.png'; ?>"
                                alt="Nitish_Profile_image" class="w-full h-full object-cover rounded-[1.7rem]">


                            <!-- Floating badges -->
                            <div class="absolute top-6 right-6 glass rounded-2xl px-4 py-3 flex items-center gap-2 ">
                                <i class="fa-solid fa-code text-[#ff6b35]"></i>
                                <div>
                                    <div class="text-xs  text-gray-400">Experience</div>
                                    <div class="font-bold text-[#5f2c1d] text-sm">1+ Years</div>
                                </div>
                            </div>

                            <div
                                class="absolute bottom-6 left-6 glass rounded-2xl px-4 py-3 flex items-center gap-2 bg-red-500">
                                <i class="fa-solid fa-trophy text-[#ffb627]"></i>
                                <div>
                                    <div class="text-xs text-gray-400">Projects</div>
                                    <div class="font-bold text-sm">120+ Done</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-500">
                <span class="text-xs mono">SCROLL</span>
                <div class="w-px h-12 bg-gradient-to-b from-[#ff6b35] to-transparent"></div>
            </div>
        </div>
    </section>

    <!-- ============ MARQUEE ============ -->
    <section class="relative py-8 border-y border-white/5 overflow-hidden z-10">
        <div class="marquee whitespace-nowrap">
            <div class="flex items-center gap-12 pr-12 text-3xl md:text-5xl font-display font-bold text-gray-700">
                <span>Web Design</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Development</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>UI / UX</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Branding</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Motion</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
            </div>
            <div class="flex items-center gap-12 pr-12 text-3xl md:text-5xl font-display font-bold text-gray-700">
                <span>Web Design</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Development</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>UI / UX</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Branding</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
                <span>Motion</span><i class="fa-solid fa-asterisk text-[#ff6b35]"></i>
            </div>
        </div>
    </section>

    <!-- ============ ABOUT ============ -->
    <section id="about" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <span class="mono text-sm text-[#ff6b35]">// 01. About Me</span>
                    <h2 class="font-display font-bold text-4xl md:text-5xl mt-4 mb-8 leading-tight">
                        Turning ideas into <span class="gradient-text">immersive</span> digital reality.
                    </h2>
                    <p class="text-gray-400 leading-relaxed mb-6 text-lg">
                        <!-- I'm Aarav — a multidisciplinary creative based in Mumbai, India. With over 5 years of experience
                        building products for startups and global brands, I help founders bring their vision to life
                        through thoughtful design and clean, scalable code. -->
                        <?php echo nl2br($profile['about_me']); ?>
                    </p>
                    <!-- <p class="text-gray-400 leading-relaxed mb-8">
                        My approach blends aesthetic sensibility with technical precision. Every pixel matters,
                        every millisecond counts. When I'm not shipping, you'll find me experimenting with WebGL,
                        mentoring juniors, or chasing the perfect cup of pour-over coffee.
                    </p> -->

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-[#ff6b35]"></i>
                            <span class="text-sm text-gray-300">Clean Code</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-[#ff6b35]"></i>
                            <span class="text-sm text-gray-300">Pixel Perfect</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-[#ff6b35]"></i>
                            <span class="text-sm text-gray-300">On-Time Delivery</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-[#ff6b35]"></i>
                            <span class="text-sm text-gray-300">24/7 Support</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Name</div>
                            <div class="font-medium"><?php echo $profile['name']; ?></div>
                        </div>
                        <div class="w-px bg-white/10"></div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Email</div>
                            <div class="font-medium"><?php echo $profile['email']; ?></div>
                        </div>
                        <div class="w-px bg-white/10"></div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Location</div>
                            <div class="font-medium"><?php echo $profile['address']; ?></div>
                        </div>
                    </div>
                </div>

                <div class="reveal grid grid-cols-2 gap-4">
                    <div class="glow-card glass rounded-2xl p-6">
                        <div class="counter font-display text-5xl font-bold gradient-text" data-target="120">0</div>
                        <div class="text-sm text-gray-400 mt-2">Projects Completed</div>
                    </div>
                    <div class="glow-card glass rounded-2xl p-6 mt-8">
                        <div class="counter font-display text-5xl font-bold gradient-text" data-target="85">0</div>
                        <div class="text-sm text-gray-400 mt-2">Happy Clients</div>
                    </div>
                    <div class="glow-card glass rounded-2xl p-6">
                        <div class="counter font-display text-5xl font-bold gradient-text" data-target="5">0</div>
                        <div class="text-sm text-gray-400 mt-2">Years Experience</div>
                    </div>
                    <div class="glow-card glass rounded-2xl p-6 mt-8">
                        <div class="counter font-display text-5xl font-bold gradient-text" data-target="15">0</div>
                        <div class="text-sm text-gray-400 mt-2">Awards Won</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SERVICES ============ -->
    <section id="services" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 02. Services</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">What I <span
                        class="gradient-text">Do</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Comprehensive solutions to take your idea from concept to
                    launch —
                    beautifully.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">Web Development</h3>
                    <p class="text-gray-400 mb-4">Custom, scalable web apps using modern stacks like React, Next.js,
                        Node, and
                        Laravel.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Frontend & Backend</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> API
                            Integration</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Performance Optimization</li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group" style="transition-delay:0.1s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00d9ff] to-[#ff6b35] flex items-center justify-center text-black text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-pen-ruler"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">UI / UX Design</h3>
                    <p class="text-gray-400 mb-4">User-centered interfaces that convert. From wireframes to
                        high-fidelity
                        prototypes.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> User
                            Research</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Wireframing</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> Design
                            Systems</li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group" style="transition-delay:0.2s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#ffb627] to-[#ff6b35] flex items-center justify-center text-black text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">Mobile Apps</h3>
                    <p class="text-gray-400 mb-4">Cross-platform mobile experiences with React Native and Flutter.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> iOS &
                            Android</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> App
                            Store Deploy</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Maintenance</li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-[#ff6b35] flex items-center justify-center text-white text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">Branding</h3>
                    <p class="text-gray-400 mb-4">Memorable brand identities — logos, color systems, and visual
                        languages.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> Logo
                            Design</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> Brand
                            Guidelines</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> Visual
                            Identity</li>
                    </ul>
                </div>

                <!-- Service 5 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group" style="transition-delay:0.1s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#ff6b35] to-pink-500 flex items-center justify-center text-white text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">SEO & Analytics</h3>
                    <p class="text-gray-400 mb-4">Rank higher, convert better. Data-driven optimization strategies.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Technical SEO</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> Speed
                            Audits</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Analytics Setup</li>
                    </ul>
                </div>

                <!-- Service 6 -->
                <div class="glow-card glass rounded-3xl p-8 reveal group" style="transition-delay:0.2s">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00d9ff] to-purple-500 flex items-center justify-center text-white text-2xl mb-6 group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-3">Motion & 3D</h3>
                    <p class="text-gray-400 mb-4">Interactive 3D and motion design with Three.js, GSAP, and WebGL.</p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i> 3D
                            Experiences</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Animations</li>
                        <li class="flex items-center gap-2"><i
                                class="fa-solid fa-chevron-right text-[#ff6b35] text-xs"></i>
                            Creative Coding</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SKILLS ============ -->
    <section id="skills" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 03. Skills</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">My <span
                        class="gradient-text">Toolkit</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Technologies and tools I use to bring ideas to life.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-6">Technical Proficiency</h3>
                    <div class="space-y-6">

                        <?php 
                          $skills = getSkills($pdo);
                         foreach($skills as $skill): ?>

                        <div class="skill-item">
                            <div class="flex justify-between mb-2"><span
                                    class="font-medium"><?php echo $skill['skill_name']; ?></span><span
                                    class="text-sm text-gray-400"><?php echo $skill['percentage']; ?>%</span></div>
                            <div class="skill-bar">
                                <div class="skill-fill" data-width="92"></div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-6">Tools & Technologies</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-react text-4xl text-[#61dafb] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">React</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-js text-4xl text-[#f7df1e] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">JavaScript</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-node-js text-4xl text-[#339933] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Node.js</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-php text-4xl text-[#777bb4] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">PHP</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-html5 text-4xl text-[#e34f26] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">HTML5</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-css3-alt text-4xl text-[#1572b6] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">CSS3</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-figma text-4xl text-[#f24e1e] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Figma</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-git-alt text-4xl text-[#f05032] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Git</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-python text-4xl text-[#3776ab] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Python</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-docker text-4xl text-[#2496ed] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Docker</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-brands fa-aws text-4xl text-[#ff9900] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">AWS</span>
                        </div>
                        <div class="glass rounded-2xl p-4 text-center glow-card cursor-pointer group">
                            <i
                                class="fa-solid fa-database text-4xl text-[#00d9ff] mb-2 group-hover:scale-110 transition-transform block"></i>
                            <span class="text-xs text-gray-400">Databases</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ================  original MY servises =========== -->

    <section id="certificates" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 06. My Services</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">Our Features <span
                        class="gradient-text">& Services</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">I provide professional, high-quality services to help your
                    business grow and turn your innovative ideas into successful realities.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <?php 
                    // Database se services fetch kar rahe hain
                    $services = getServices($pdo);
    
                    // Yahan se Loop start ho raha hai
                  foreach($services as $service): 
                  ?>

                <div class="glow-card glass rounded-2xl p-6 reveal text-center group">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-2xl text-black group-hover:rotate-6 transition-transform">

                        <?php 
                              $icon_data = $service['icon'];
                              // Check image link or local path
                              if (filter_var($icon_data, FILTER_VALIDATE_URL)) {
                                  $img_src = htmlspecialchars($icon_data);
                                } else {
                               // Path theek se check kar lein, agar home.php root folder me hai to ye path sahi hai
                                 $img_src = 'assets/images/services/' . htmlspecialchars($icon_data);
                                 }
                          ?>
                        <img src="<?php echo $img_src; ?>" alt="Service Image" class="w-10 h-10 object-contain">

                    </div>

                    <h4 class="font-display font-bold mb-1"><?php echo htmlspecialchars($service['service_name']); ?>
                    </h4>

                    <p class="text-xs text-gray-400 mb-2"><?php echo htmlspecialchars($service['description']); ?></p>

                    <!-- <span class="mono text-xs text-[#ffb627]">2024</span> -->
                </div>

                <?php 
                // Yahan Loop end ho raha hai
                endforeach; 
                  ?>

            </div>
        </div>
    </section>


    <!-- ============ PROJECTS ============ -->


    <!-- <section id="projects" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-wrap items-end justify-between gap-6 mb-12 reveal">
                <div>
                    <span class="mono text-sm text-[#ff6b35]">// 04. Portfolio</span>
                    <h2 class="font-display font-bold text-4xl md:text-6xl mt-4">Featured <span
                            class="gradient-text">Work</span>
                    </h2>
                </div>
                <p class="text-gray-400 max-w-md">A selection of recent projects spanning web, mobile, and brand
                    identity work.
                </p>
            </div>

            
            <div class="flex gap-2 mb-8 overflow-x-auto no-scrollbar pb-2 reveal">
                <button class="filter-pill active px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="all">All
                    Projects</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="web">Web</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="mobile">Mobile</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="design">Design</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="branding">Branding</button>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="web">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">WEB APP</span>
                        <h3 class="font-display font-bold text-2xl mb-2">Fintech Dashboard</h3>
                        <p class="text-sm text-gray-300 mb-4">A modern banking dashboard with real-time analytics
                            and
                            transaction
                            management.</p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">React</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Node.js</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">D3.js</span>
                        </div>
                    </div>
                </div>

                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="mobile"
                    style="transition-delay:0.1s">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">MOBILE APP</span>
                        <h3 class="font-display font-bold text-2xl mb-2">FitTrack Pro</h3>
                        <p class="text-sm text-gray-300 mb-4">Fitness companion app with workout plans, nutrition
                            tracking & social
                            features.</p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">React Native</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Firebase</span>
                        </div>
                    </div>
                </div>

                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="design"
                    style="transition-delay:0.2s">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559028012-481c04fa702d?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">UI/UX</span>
                        <h3 class="font-display font-bold text-2xl mb-2">SaaS Landing Page</h3>
                        <p class="text-sm text-gray-300 mb-4">Conversion-optimized landing page design for a B2B
                            SaaS
                            platform.</p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Figma</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Webflow</span>
                        </div>
                    </div>
                </div>

                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="branding">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">BRANDING</span>
                        <h3 class="font-display font-bold text-2xl mb-2">Bloom Coffee Co.</h3>
                        <p class="text-sm text-gray-300 mb-4">Complete brand identity for a specialty coffee
                            roaster.
                        </p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Logo</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Identity</span>
                        </div>
                    </div>
                </div>

                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="web"
                    style="transition-delay:0.1s">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">WEB APP</span>
                        <h3 class="font-display font-bold text-2xl mb-2">Analytics Platform</h3>
                        <p class="text-sm text-gray-300 mb-4">Enterprise analytics platform with custom reporting
                            and AI
                            insights.
                        </p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Vue.js</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Python</span>
                        </div>
                    </div>
                </div>

                
                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal" data-category="mobile"
                    style="transition-delay:0.2s">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="project-overlay">
                        <span class="mono text-xs text-[#ffb627] mb-2">MOBILE APP</span>
                        <h3 class="font-display font-bold text-2xl mb-2">Wanderlust Travel</h3>
                        <p class="text-sm text-gray-300 mb-4">Travel planning app with maps, itineraries, and
                            offline
                            support.</p>
                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Flutter</span>
                            <span class="text-xs px-3 py-1 rounded-full bg-white/10">Maps API</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12 reveal">
                <a href="#" class="btn-primary px-8 py-3.5 rounded-full inline-flex items-center gap-2">
                    <span>View All Projects</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>
                </a>
            </div>
        </div>
    </section> -->


    <section id="projects" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-wrap items-end justify-between gap-6 mb-12 reveal">
                <div>
                    <span class="mono text-sm text-[#ff6b35]">// 04. Portfolio</span>
                    <h2 class="font-display font-bold text-4xl md:text-6xl mt-4">Featured <span
                            class="gradient-text">Work</span>
                    </h2>
                </div>
                <p class="text-gray-400 max-w-md">A selection of recent projects spanning web, mobile, and brand
                    identity work.
                </p>
            </div>

            <div class="flex gap-2 mb-8 overflow-x-auto no-scrollbar pb-2 reveal" id="filter-container">
                <button class="filter-pill active px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="all">All Projects</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="web">Web</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="mobile">Mobile</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="design">Design</button>
                <button class="filter-pill px-5 py-2 rounded-full text-sm whitespace-nowrap glass"
                    data-filter="branding">Branding</button>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="project-grid">
                <?php 
            $projects = getProjects($pdo);
            $modalIndex = 0;
            foreach($projects as $project): 
                $modalIndex++;
                // Convert category to lowercase for filtering
                $itemCategory = strtolower(htmlspecialchars($project['category'])); 
                $imageName = !empty($project['image']) ? $project['image'] : 'default.jpg';
            ?>

                <div class="project-card glow-card glass rounded-3xl overflow-hidden reveal flex flex-col"
                    data-category="<?php echo $itemCategory; ?>">

                    <!-- <div class="aspect-[4/3] relative overflow-hidden group">
                        <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>"
                            alt="<?php echo htmlspecialchars($project['title']); ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4">

                            <?php if(!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank"
                                class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-[#ff6b35] transition-colors border border-white/20">
                                <i class="fas fa-link"></i>
                            </a>
                            <?php endif; ?>

                            <button onclick="openModal('modal-<?php echo $modalIndex; ?>')"
                                class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-[#ff6b35] transition-colors border border-white/20">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div> -->
                    <div
                        class="aspect-[4/3] relative overflow-hidden group bg-black/20 flex items-center justify-center">

                        <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>"
                            alt="<?php echo htmlspecialchars($project['title']); ?>"
                            class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110">

                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4">

                            <?php if(!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank"
                                class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-[#ff6b35] transition-colors border border-white/20">
                                <i class="fas fa-link"></i>
                            </a>
                            <?php endif; ?>

                            <button onclick="openModal('modal-<?php echo $modalIndex; ?>')"
                                class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center hover:bg-[#ff6b35] transition-colors border border-white/20">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <span class="mono text-xs text-[#ffb627] mb-2 uppercase tracking-wider">
                            <?php echo htmlspecialchars($project['category']); ?>
                        </span>
                        <h3 class="font-display font-bold text-2xl mb-2 text-white">
                            <?php echo htmlspecialchars($project['title']); ?>
                        </h3>
                        <!-- <p class="text-sm text-gray-400 mb-4 line-clamp-3">
                            <?php echo htmlspecialchars($project['description']); ?>
                        </p> -->

                        <p class="text-sm text-gray-400 mb-4">
                            <?php
                                $description = htmlspecialchars($project['description']);
                                   $words = explode(' ', $description);

                                       if (count($words) > 10) {
                                         echo implode(' ', array_slice($words, 0, 10)) . '...';
                                            } else {
                                             echo $description;
                                        }
                            ?>
                        </p>
                    </div>
                </div>

                <div id="modal-<?php echo $modalIndex; ?>"
                    class="fixed inset-0 z-[9999] hidden items-center justify-center transition-all duration-300">
                    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm cursor-pointer"
                        onclick="closeModal('modal-<?php echo $modalIndex; ?>')"></div>

                    <!-- <div class="relative z-10 w-full max-w-5xl mx-4 flex flex-col items-center animate-zoom-in"> -->
                    <div
                        class="relative z-10 w-full max-w-5xl mx-4 my-8 flex flex-col items-center animate-zoom-in max-h-[90vh] overflow-y-auto no-scrollbar pb-6 rounded-2xl">
                        <button onclick="closeModal('modal-<?php echo $modalIndex; ?>')"
                            class="absolute -top-12 right-0 text-white hover:text-[#ff6b35] transition-colors p-2">
                            <i class="fas fa-times text-3xl"></i>
                        </button>

                        <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>"
                            class="w-full max-h-[75vh] object-contain rounded-xl shadow-2xl mb-6 bg-black/50"
                            alt="<?php echo htmlspecialchars($project['title']); ?>">

                        <?php if(!empty($project['description'])): ?>
                        <div
                            class="w-full bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white/20 shadow-2xl text-center">

                            <p class="text-gray-200 text-base leading-relaxed whitespace-pre-wrap">
                                <?php echo htmlspecialchars($project['description']); ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($project['link'])): ?>
                        <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank"
                            class="px-8 py-3 bg-[#ff6b35] text-white rounded-full font-medium hover:bg-[#e55a2b] transition-colors shadow-[0_0_20px_rgba(255,107,53,0.3)] flex items-center gap-2">
                            <span>Visit Project</span>
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12 reveal">
                <a href="#"
                    class="btn-primary px-8 py-3.5 rounded-full inline-flex items-center gap-2 text-white bg-[#ff6b35] hover:bg-[#e55a2b] transition-colors">
                    <span>View All Projects</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>
                </a>
            </div>
        </div>
    </section>

    <script>
    // Modal Logic
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Stop background scrolling
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto'; // Restore background scrolling
    }

    // Close modal on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            const openModals = document.querySelectorAll('[id^="modal-"].flex');
            openModals.forEach(modal => closeModal(modal.id));
        }
    });

    // Filter Logic
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll('.filter-pill');
        const projectCards = document.querySelectorAll('.project-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active state from all
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-[#ff6b35]', 'text-white',
                        'border-transparent');
                });

                // Add active state to clicked
                this.classList.add('active', 'bg-[#ff6b35]', 'text-white',
                    'border-transparent');

                const filterValue = this.getAttribute('data-filter').toLowerCase();

                projectCards.forEach(card => {
                    const category = card.getAttribute('data-category');

                    if (filterValue === 'all' || category === filterValue) {
                        card.style.display =
                            'flex'; // Use flex because card is flex-col
                        // Optional: Add a small animation effect
                        card.style.opacity = '0';
                        setTimeout(() => card.style.opacity = '1', 50);
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
    </script>

    <style>
    /* Line clamp utility if not present in your tailwind config */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Modal animation */
    @keyframes zoomIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-zoom-in {
        animation: zoomIn 0.3s ease-out forwards;
    }

    /* Default active styling for first button load */
    .filter-pill.active {
        background-color: #ff6b35;
        color: white;
        border-color: transparent;
    }
    </style>




    <!-- ============ EXPERIENCE ============ -->
    <section id="experience" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 05. Experience</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">My <span
                        class="gradient-text">Journey</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Education and professional experience that shaped my
                    career.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Experience -->
                <!-- <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-briefcase text-[#ff6b35]"></i>
                        Work Experience
                    </h3>
                    <div class="relative pl-16">
                        <div class="timeline-line"></div>

                        <div class="relative mb-10">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">Senior Full-Stack Developer</h4>
                                    <span class="mono text-xs text-[#ffb627]">2023 — Present</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">TechVision Labs</p>
                                <p class="text-gray-400 text-sm">Leading development of enterprise SaaS products.
                                    Mentoring 4 junior
                                    devs, architecting scalable solutions.</p>
                            </div>
                        </div>

                        <div class="relative mb-10">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center">
                                <i class="fa-solid fa-code text-[#ff6b35]"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">Full-Stack Developer</h4>
                                    <span class="mono text-xs text-gray-400">2021 — 2023</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">Digital Forge Studio</p>
                                <p class="text-gray-400 text-sm">Built 30+ client projects across e-commerce,
                                    fintech,
                                    and healthcare
                                    domains using React & Laravel.</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center">
                                <i class="fa-solid fa-seedling text-[#00d9ff]"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">Junior Web Developer</h4>
                                    <span class="mono text-xs text-gray-400">2019 — 2021</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">StartHub Inc.</p>
                                <p class="text-gray-400 text-sm">Started my career building WordPress sites and
                                    small
                                    React
                                    applications. Learned the ropes.</p>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-briefcase text-[#ff6b35]"></i>
                        Work Experience
                    </h3>
                    <div class="relative pl-16">
                        <div class="timeline-line"></div>

                        <?php 
        // Database se experiences fetch karein, latest sabse upar aayega
        $stmt = $pdo->query("SELECT * FROM experiences ORDER BY start_date DESC");
        $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = 0; // Index track karne ke liye (taaki pehle wale ko star icon mile)
        
        foreach($experiences as $exp): 
            // Date formatting: (e.g., "2021")
            $startYear = date('Y', strtotime($exp['start_date']));
            
            if ($exp['is_current']) {
                $dateRange = $startYear . ' — Present';
            } else {
                $endYear = date('Y', strtotime($exp['end_date']));
                $dateRange = $startYear . ' — ' . $endYear;
            }
            
            // Check if it's the first (latest) experience
            $isLatest = ($count === 0);
        ?>

                        <div class="relative mb-10">
                            <?php if ($isLatest): ?>
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black shadow-[0_0_15px_rgba(255,107,53,0.5)]">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <?php else: ?>
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center border border-white/10">
                                <i
                                    class="fa-solid <?php echo ($count % 2 == 0) ? 'fa-seedling text-[#00d9ff]' : 'fa-code text-[#ff6b35]'; ?>"></i>
                            </div>
                            <?php endif; ?>

                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg text-white">
                                        <?php echo htmlspecialchars($exp['position']); ?>
                                    </h4>
                                    <span
                                        class="mono text-xs <?php echo $isLatest ? 'text-[#ffb627]' : 'text-gray-400'; ?>">
                                        <?php echo $dateRange; ?>
                                    </span>
                                </div>

                                <p class="text-sm text-[#ff6b35] mb-3 font-medium">
                                    <?php echo htmlspecialchars($exp['company']); ?>
                                </p>

                                <p class="text-gray-400 text-sm leading-relaxed ">
                                    <?php echo htmlspecialchars($exp['description']); ?>
                                </p>
                            </div>
                        </div>

                        <?php 
            $count++;
        endforeach; 
        
        // Agar database khali ho toh default message
        if(empty($experiences)):
        ?>
                        <div class="text-gray-500 italic mt-4">No work experience added yet.</div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Education -->
                <!-- <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-[#ff6b35]"></i>
                        Education
                    </h3>
                    <div class="relative pl-16">
                        <div class="timeline-line"></div>

                        <div class="relative mb-10">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">M.Sc. Computer Science</h4>
                                    <span class="mono text-xs text-[#ffb627]">2017 — 2019</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">IIT Bombay</p>
                                <p class="text-gray-400 text-sm">Specialized in Human-Computer Interaction and
                                    Distributed Systems. GPA:
                                    3.9/4.0</p>
                            </div>
                        </div>

                        <div class="relative mb-10">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center">
                                <i class="fa-solid fa-book text-[#ff6b35]"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">B.Tech Information Technology</h4>
                                    <span class="mono text-xs text-gray-400">2013 — 2017</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">Mumbai University</p>
                                <p class="text-gray-400 text-sm">Foundation in algorithms, data structures, web
                                    technologies. Graduated
                                    with honors.</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center">
                                <i class="fa-solid fa-school text-[#00d9ff]"></i>
                            </div>
                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg">Higher Secondary (Science)</h4>
                                    <span class="mono text-xs text-gray-400">2011 — 2013</span>
                                </div>
                                <p class="text-sm text-[#ff6b35] mb-3">Delhi Public School</p>
                                <p class="text-gray-400 text-sm">PCM with Computer Science. School topper in CS.
                                    Started
                                    coding at 15.
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="reveal">
                    <h3 class="font-display font-bold text-2xl mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-[#ff6b35]"></i>
                        Education
                    </h3>
                    <div class="relative pl-16">
                        <div class="timeline-line"></div>

                        <?php 
        // Education table se data fetch karein (Latest pehle)
        $stmt = $pdo->query("SELECT * FROM education ORDER BY start_date DESC");
        $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = 0; // Index track karne ke liye
        
        foreach($educations as $edu): 
            // Date formatting: Sirf Year nikal rahe hain
            $startYear = date('Y', strtotime($edu['start_date']));
            
            // Agar end_date NULL ya empty hai toh "Present" warna End Year
            if (empty($edu['end_date'])) {
                $dateRange = $startYear . ' — Present';
            } else {
                $endYear = date('Y', strtotime($edu['end_date']));
                $dateRange = $startYear . ' — ' . $endYear;
            }
            
            // Check if it's the latest entry
            $isLatest = ($count === 0);
        ?>

                        <div class="relative <?php echo ($count === count($educations) - 1) ? '' : 'mb-10'; ?>">

                            <?php if ($isLatest): ?>
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <?php else: ?>
                            <div
                                class="absolute -left-16 top-1 w-12 h-12 rounded-full glass flex items-center justify-center">
                                <?php if ($count % 2 != 0): ?>
                                <i class="fa-solid fa-book text-[#ff6b35]"></i>
                                <?php else: ?>
                                <i class="fa-solid fa-school text-[#00d9ff]"></i>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div class="glass rounded-2xl p-6 glow-card">
                                <div class="flex flex-wrap justify-between gap-2 mb-2">
                                    <h4 class="font-display font-bold text-lg text-white">
                                        <?php echo htmlspecialchars($edu['degree']); ?>
                                    </h4>

                                    <?php if ($isLatest): ?>
                                    <span class="mono text-xs text-[#ffb627]">
                                        <?php echo $dateRange; ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="mono text-xs text-gray-400">
                                        <?php echo $dateRange; ?>
                                    </span>
                                    <?php endif; ?>
                                </div>

                                <p class="text-sm text-[#ff6b35] mb-3">
                                    <?php echo htmlspecialchars($edu['institution']); ?>
                                </p>

                                <p class="text-gray-400 text-sm ">
                                    <?php echo htmlspecialchars($edu['description']); ?>
                                </p>
                            </div>
                        </div>

                        <?php 
            $count++;
        endforeach; 
        
        // Agar database me koi data na ho
        if(empty($educations)):
        ?>
                        <div class="text-gray-500 italic mt-4">No education details added yet.</div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============ CERTIFICATES ============ -->
    <section id="certificates" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 06. Achievements</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">Certifications & <span
                        class="gradient-text">Awards</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Continuous learning and recognition from industry
                    leaders.
                </p>
            </div>

            <!-- <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glow-card glass rounded-2xl p-6 reveal text-center group">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-2xl text-black group-hover:rotate-6 transition-transform">
                        <i class="fa-brands fa-aws"></i>
                    </div>
                    <h4 class="font-display font-bold mb-1">AWS Solutions Architect</h4>
                    <p class="text-xs text-gray-400 mb-2">Amazon Web Services</p>
                    <span class="mono text-xs text-[#ffb627]">2024</span>
                </div>

                <div class="glow-card glass rounded-2xl p-6 reveal text-center group" style="transition-delay:0.1s">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-[#00d9ff] to-[#ff6b35] flex items-center justify-center text-2xl text-black group-hover:rotate-6 transition-transform">
                        <i class="fa-brands fa-google"></i>
                    </div>
                    <h4 class="font-display font-bold mb-1">UX Design Professional</h4>
                    <p class="text-xs text-gray-400 mb-2">Google Career Certificates</p>
                    <span class="mono text-xs text-[#ffb627]">2023</span>
                </div>

                <div class="glow-card glass rounded-2xl p-6 reveal text-center group" style="transition-delay:0.2s">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-[#ffb627] to-[#ff6b35] flex items-center justify-center text-2xl text-black group-hover:rotate-6 transition-transform">
                        <i class="fa-brands fa-meta"></i>
                    </div>
                    <h4 class="font-display font-bold mb-1">Front-End Developer</h4>                                        
                    <p class="text-xs text-gray-400 mb-2">Meta (Facebook)</p>
                    <span class="mono text-xs text-[#ffb627]">2023</span>
                </div>

                <div class="glow-card glass rounded-2xl p-6 reveal text-center group" style="transition-delay:0.3s">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-500 to-[#ff6b35] flex items-center justify-center text-2xl text-black group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <h4 class="font-display font-bold mb-1">Awwwards SOTD</h4>
                    <p class="text-xs text-gray-400 mb-2">Site of the Day Winner</p>
                    <span class="mono text-xs text-[#ffb627]">2022</span>
                </div>
            </div> -->


            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php 
    // Database se certificates fetch karein (Latest pehle)
    $stmt = $pdo->query("SELECT * FROM certificates ORDER BY date_issued DESC");
    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $delay = 0; // Animation delay ke liye
    $modalIndex = 0; // Modal ki unique ID ke liye
    
    foreach($certificates as $cert): 
        $modalIndex++;
        // Date se sirf year nikalna
        $year = date('Y', strtotime($cert['date_issued']));
        // Image check
        $imageName = !empty($cert['image']) ? $cert['image'] : 'default_cert.jpg';
    ?>

                <div class="glow-card glass rounded-2xl p-6 reveal text-center group"
                    style="transition-delay: <?php echo $delay; ?>s">

                    <div onclick="openCertModal('certModal-<?php echo $modalIndex; ?>')"
                        class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden cursor-pointer flex items-center justify-center text-black group-hover:rotate-6 transition-transform relative ring-2 ring-[#ffb627]/50 hover:ring-[#ff6b35]">

                        <img src="assets/images/certificates/<?php echo htmlspecialchars($imageName); ?>"
                            alt="<?php echo htmlspecialchars($cert['title']); ?>" class="w-full h-full object-cover">

                        <div
                            class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-expand text-white text-xl"></i>
                        </div>
                    </div>

                    <h4 class="font-display font-bold mb-1"><?php echo htmlspecialchars($cert['title']); ?></h4>
                    <p class="text-xs text-gray-400 mb-2"><?php echo htmlspecialchars($cert['issuer']); ?></p>
                    <span class="mono text-xs text-[#ffb627]"><?php echo $year; ?></span>
                </div>

                <div id="certModal-<?php echo $modalIndex; ?>"
                    class="fixed inset-0 z-[9999] hidden items-center justify-center transition-all duration-300">
                    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm cursor-pointer"
                        onclick="closeCertModal('certModal-<?php echo $modalIndex; ?>')"></div>

                    <div class="relative z-10 w-full max-w-4xl mx-4 flex flex-col items-center animate-zoom-in">
                        <button onclick="closeCertModal('certModal-<?php echo $modalIndex; ?>')"
                            class="absolute -top-12 right-0 text-white hover:text-[#ff6b35] transition-colors p-2">
                            <i class="fas fa-times text-3xl"></i>
                        </button>

                        <img src="assets/images/certificates/<?php echo htmlspecialchars($imageName); ?>"
                            class="w-full max-h-[80vh] object-contain rounded-xl shadow-[0_0_30px_rgba(255,107,53,0.2)] bg-black/50"
                            alt="<?php echo htmlspecialchars($cert['title']); ?>">

                        <div
                            class="mt-5 text-center bg-white/10 backdrop-blur-md px-8 py-3 rounded-full border border-white/10">
                            <h3 class="text-[#ffb627] font-display font-bold text-xl">
                                <?php echo htmlspecialchars($cert['title']); ?></h3>
                            <p class="text-gray-300 text-sm"><?php echo htmlspecialchars($cert['issuer']); ?> • <span
                                    class="mono"><?php echo $year; ?></span></p>
                        </div>
                    </div>
                </div>

                <?php 
        $delay += 0.1; // Har card ka animation thoda late aayega
    endforeach; 
    
    // Agar koi certificate na ho toh
    if(empty($certificates)):
    ?>
                <div class="col-span-full text-center text-gray-500 italic py-8">No certificates added yet.</div>
                <?php endif; ?>
            </div>

            <script>
            function openCertModal(modalId) {
                const modal = document.getElementById(modalId);
                document.body.appendChild(modal); // Brings modal to the very front, above everything
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // Prevents background scrolling
            }

            function closeCertModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto'; // Restores scrolling
            }

            // Close on Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    const openModals = document.querySelectorAll('[id^="certModal-"].flex');
                    openModals.forEach(modal => closeCertModal(modal.id));
                }
            });
            </script>

            <style>
            /* Zoom In Animation for Popups */
            @keyframes zoomIn {
                from {
                    transform: scale(0.95);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .animate-zoom-in {
                animation: zoomIn 0.3s ease-out forwards;
            }
            </style>


        </div>
    </section>

    <!-- ============ RESUME ============ -->
    <section class="relative py-24 z-10">
        <div class="max-w-5xl mx-auto px-6">
            <div class="glass rounded-3xl p-8 md:p-12 relative overflow-hidden reveal">
                <div
                    class="absolute -top-20 -right-20 w-64 h-64 bg-gradient-to-br from-[#ff6b35] to-[#ffb627] rounded-full opacity-20 blur-3xl">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 w-64 h-64 bg-gradient-to-br from-[#00d9ff] to-[#ff6b35] rounded-full opacity-20 blur-3xl">
                </div>

                <div
                    class="relative flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                    <div>
                        <span class="mono text-sm text-[#ff6b35]">// 07. Resume</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl mt-3 mb-2">Want my full resume?</h2>
                        <p class="text-gray-400">Download a comprehensive PDF with all my details.</p>
                    </div>
                    <button onclick="showToast('Resume download starting...')"
                        class="btn-primary px-8 py-4 rounded-full inline-flex items-center gap-3 whitespace-nowrap">
                        <i class="fa-solid fa-download"></i>
                        <span>Download CV</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT ============ -->
    <section id="contact" class="relative py-24 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="mono text-sm text-[#ff6b35]">// 08. Contact</span>
                <h2 class="font-display font-bold text-4xl md:text-6xl mt-4 mb-4">Let's <span
                        class="gradient-text">Connect</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Have a project in mind? Drop me a message and let's
                    create
                    something
                    amazing together.</p>
            </div>

            <div class="grid lg:grid-cols-5 gap-8">
                <!-- Contact Info -->
                <div class="lg:col-span-2 space-y-4 reveal">
                    <a href="mailto:hello@aarav.dev"
                        class="glow-card glass rounded-2xl p-6 flex items-center gap-4 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center text-black group-hover:rotate-6 transition-transform">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Email</div>
                            <div class="font-medium"><?php echo $profile['email']; ?></div>
                        </div>
                    </a>

                    <a href="tel:+919876543210" class="glow-card glass rounded-2xl p-6 flex items-center gap-4 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#00d9ff] to-[#ff6b35] flex items-center justify-center text-black group-hover:rotate-6 transition-transform">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Phone</div>
                            <div class="font-medium">+91 - <?php echo $profile['phone']; ?></div>
                        </div>
                    </a>

                    <div class="glow-card glass rounded-2xl p-6 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ffb627] to-[#ff6b35] flex items-center justify-center text-black">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Location</div>
                            <div class="font-medium"><?php echo $profile['address']; ?></div>
                        </div>
                    </div>

                    <div class="glow-card glass rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="pulse-dot w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-sm font-medium">Currently Available</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-4">Open to freelance projects and full-time
                            opportunities.
                            Average
                            response time: 2 hours.</p>
                        <div class="flex gap-2">
                            <!-- <a href="#"
                                class="w-9 h-9 rounded-lg glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition"><i
                                    class="fa-brands fa-github text-sm"></i></a>
                            <a href="#"
                                class="w-9 h-9 rounded-lg glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition"><i
                                    class="fa-brands fa-linkedin-in text-sm"></i></a>
                            <a href="#"
                                class="w-9 h-9 rounded-lg glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition"><i
                                    class="fa-brands fa-twitter text-sm"></i></a>
                            <a href="#"
                                class="w-9 h-9 rounded-lg glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition"><i
                                    class="fa-brands fa-dribbble text-sm"></i></a> -->
                            <?php if (!empty($profile['github'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1">
                                <i class="fa-brands fa-github"></i>
                            </a>
                            <?php endif; ?>

                            <?php if (!empty($profile['linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-linkedin-in"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-facebook"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-twitter"></i></a> <?php endif; ?>

                            <?php if (!empty($profile['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($profile['instagram']); ?>" target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                    class="fa-brands fa-instagram"></i></a> <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <!-- <form id="contactForm" class="lg:col-span-3 glass rounded-3xl p-8 reveal"
                    onsubmit="return handleSubmit(event)">
                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Your Name</label>
                            <input type="text" required class="input-field w-full px-4 py-3 rounded-xl text-white"
                                placeholder="Your Name">
                        </div>
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Email Address</label>
                            <input type="email" required class="input-field w-full px-4 py-3 rounded-xl text-white"
                                placeholder="abcde@example.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-gray-400 mb-2 block">Subject</label>
                        <input type="text" required class="input-field w-full px-4 py-3 rounded-xl text-white"
                            placeholder="Project discussion">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                        <label class="text-sm text-gray-400 mb-2 block">Budget Range</label>
                        <select class="input-field w-full px-4 py-3 rounded-xl text-white">
                            <option style="background:#13131c">Select budget</option>
                            <option style="background:#13131c">500 Rs - 1,000 Rs</option>
                            <option style="background:#13131c">1,000 Rs - 5,000 Rs</option>
                            <option style="background:#13131c">5,000 Rs - 10,000 Rs</option>
                            <option style="background:#13131c">10,000 Rs+</option>
                        </select>
                            </div>

                            <div>
                            <label class="text-sm text-gray-400 mb-2 block">Phone Number</label>
                            <input type="phone_no" required class="input-field w-full px-4 py-3 rounded-xl text-white"
                                placeholder="91+ 1234567890">
                        </div>

                    </div>

                    <div class="mb-6">
                        <label class="text-sm text-gray-400 mb-2 block">Message</label>
                        <textarea required rows="5"
                            class="input-field w-full px-4 py-3 rounded-xl text-white resize-none"
                            placeholder="Tell me about your project..."></textarea>
                    </div>

                    <button type="submit"
                        class="btn-primary w-full py-4 rounded-xl inline-flex items-center justify-center gap-2 font-semibold">
                        <span>Send Message</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form> -->
                <form id="contactForm" class="lg:col-span-3 glass rounded-3xl p-8 reveal" action="contact-submit.php"
                    method="POST">
                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Your Name</label>
                            <input type="text" name="name" required
                                class="input-field w-full px-4 py-3 rounded-xl text-white" placeholder="Your Name">
                        </div>
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Email Address</label>
                            <input type="email" name="email" required
                                class="input-field w-full px-4 py-3 rounded-xl text-white"
                                placeholder="abcde@example.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-gray-400 mb-2 block">Subject</label>
                        <input type="text" name="subject" required
                            class="input-field w-full px-4 py-3 rounded-xl text-white" placeholder="Project discussion">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Budget Range</label>
                            <select name="budget" class="input-field w-full px-4 py-3 rounded-xl text-white">
                                <option value="" style="background:#13131c">Select budget</option>
                                <option value="500-1000" style="background:#13131c">500 Rs - 1,000 Rs</option>
                                <option value="1000-5000" style="background:#13131c">1,000 Rs - 5,000 Rs</option>
                                <option value="5000-10000" style="background:#13131c">5,000 Rs - 10,000 Rs</option>
                                <option value="10000+" style="background:#13131c">10,000 Rs+</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Phone Number</label>
                            <input type="tel" name="phone_no" required
                                class="input-field w-full px-4 py-3 rounded-xl text-white" placeholder="+91 1234567890">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="text-sm text-gray-400 mb-2 block">Message</label>
                        <textarea name="message" required rows="5"
                            class="input-field w-full px-4 py-3 rounded-xl text-white resize-none"
                            placeholder="Tell me about your project..."></textarea>
                    </div>

                    <button type="submit"
                        class="btn-primary w-full py-4 rounded-xl inline-flex items-center justify-center gap-2 font-semibold">
                        <span>Send Message</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer class="relative py-12 border-t border-white/5 z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div class="md:col-span-2">
                    <a href="#home" class="flex items-center gap-2 mb-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#ff6b35] to-[#ffb627] flex items-center justify-center font-display font-bold text-black text-lg">
                            AS</div>
                        <span class="font-display font-bold text-xl">Aarav<span class="gradient-text">.</span></span>
                    </a>
                    <p class="text-gray-400 max-w-md mb-4">Creative developer & designer crafting beautiful digital
                        experiences
                        for ambitious brands worldwide.</p>
                    <div class="flex gap-3">


                        <?php if (!empty($profile['github'])): ?>
                        <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($profile['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                class="fa-brands fa-linkedin-in"></i></a> <?php endif; ?>

                        <?php if (!empty($profile['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                class="fa-brands fa-facebook"></i></a> <?php endif; ?>

                        <?php if (!empty($profile['twitter'])): ?>
                        <a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                class="fa-brands fa-twitter"></i></a> <?php endif; ?>

                        <?php if (!empty($profile['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($profile['instagram']); ?>" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full glass flex items-center justify-center hover:bg-[#ff6b35] hover:text-black transition-all hover:-translate-y-1"><i
                                class="fa-brands fa-instagram"></i></a> <?php endif; ?>

                    </div>
                </div>

                <div>
                    <h4 class="font-display font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#about" class="hover:text-[#ff6b35] transition">About</a></li>
                        <li><a href="#services" class="hover:text-[#ff6b35] transition">Services</a></li>
                        <li><a href="#projects" class="hover:text-[#ff6b35] transition">Projects</a></li>
                        <li><a href="#contact" class="hover:text-[#ff6b35] transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-display font-bold mb-4">Get In Touch</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="mailto:hello@aarav.dev"
                                class="hover:text-[#ff6b35] transition"><?php echo $profile['email']; ?></a>
                        </li>
                        <li><a href="tel:+919876543210" class="hover:text-[#ff6b35] transition">+91
                                <?php echo $profile['phone']; ?></a></li>
                        <li><?php echo $profile['address']; ?></li>
                    </ul>
                </div>
            </div>

            <div
                class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 border-t border-white/5 text-sm text-gray-500">
                <p>© 2024 Nitish Kumar Yadav. Crafted with <i class="fa-solid fa-heart text-[#ff6b35]"></i> in
                    India.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/919517648760?text=Hello%20Nitish,%20I%20want%20to%20know%20more%20about%20your%20services."
        target="_blank"
        class="fixed bottom-20 right-6 z-50 flex items-center justify-center w-12 h-12 bg-green-500 rounded-full shadow-lg hover:bg-green-600 hover:scale-110 transition-all duration-300 animate-bounce">

        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" class="w-9 h-9">
    </a>

    <!-- Back to top -->
    <button id="backToTop"
        class="fixed bottom-5 right-6 w-12 h-12 rounded-full btn-primary items-center justify-center opacity-0 pointer-events-none transition-opacity z-40 hidden md:flex">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Toast -->
    <div id="toast"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 glass px-6 py-4 rounded-2xl flex items-center gap-3 opacity-0 pointer-events-none transition-all z-50">
        <i class="fa-solid fa-circle-check text-green-500"></i>
        <span id="toastMsg">Message sent successfully!</span>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

    <script src="assets/js/home.js"></script>



</body>

</html>