<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    {{-- <link rel="stylesheet" href="styles.css"> --}}
</head>
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.cv-container {
    background-color: #fff;
    width: 800px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.cv-header {
    text-align: center;
    margin-bottom: 20px;
}

.cv-header h1 {
    margin: 0;
    font-size: 2.5em;
}

.cv-header h2 {
    margin: 0;
    font-size: 1.5em;
    color: #888;
}

.cv-content {
    display: flex;
}

.cv-left {
    width: 35%;
    background-color: #f7f7f7;
    padding: 20px;
    border-right: 1px solid #ddd;
}

.cv-right {
    width: 65%;
    padding: 20px;
}

.cv-section {
    margin-bottom: 20px;
}

.cv-section h3 {
    margin-bottom: 10px;
    font-size: 1.2em;
    color: #333;
}

.cv-section p, .cv-section ul {
    margin: 0;
    font-size: 1em;
    color: #555;
}

.cv-section ul {
    padding-left: 20px;
}

.cv-section ul li {
    list-style-type: disc;
}
</style>
<body>
    <div class="cv-container">
        <div class="cv-header">
            <h1>{{ $candidat->nom }} </h1>
            <h2>{{ $candidat->specialisation}} </h2>
        </div>
        <div class="cv-content">
            <div class="cv-left">
                <div class="cv-section">
                    <h4>Contact :</h4>
                    <p>{{ $candidat->telephone }}</p>
                    <h4>Mail :</h4>
                    <p>{{ $candidat->email }}</p>
                    <h4>Adresse :</h4>
                    <p>{{ $candidat->adresse }}</p>
                </div>
                <div class="cv-section">
                    <h4>Date de naissance :</h4>
                    {{-- <p><strong>Secondary School</strong><br>Really Great High School<br>2010 - 2014</p>
                    <p><strong>Bachelor of Technology</strong><br>Really Great University<br>2014 - 2016</p> --}}
                    <p>{{ $candidat->date_naissance}}</p>
                </div>
                <div class="cv-section">
                    <h4>Qualite :</h4>
                    {{-- <ul>
                        <li>Web Design</li>
                        <li>Design Thinking</li>
                        <li>Wireframe Creation</li>
                        <li>Front End Coding</li>
                        <li>Backend Tech</li>
                        <li>Problem-Solving</li>
                        <li>Computer Literacy</li>
                        <li>Project Management Tools</li>
                        <li>Strong Communication</li>
                    </ul> --}}
                    <p>{{ $candidat->qualite}}</p>
                </div>

                <div class="cv-section">
                    <h4>Langue :</h4>
                    <ul>
                        @foreach ($langue_candidat as $langue)
                            <li>{{ $langue->langue }}</li>  
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="cv-right">
                {{-- <div class="cv-section">
                    <h3>Summary</h3>
                    <p>I am a qualified and professional web developer with five years of experience in database administration and website design. Strong creative and analytical skills. Team player with an eye for detail.</p>
                </div> --}}
                {{-- <div class="cv-section">
                    <h3>Experience</h3>
                    <p><strong>Applications Developer</strong><br>Really Great Company<br>2016 - Present</p>
                    <ul>
                        <li>Database administration and website design</li>
                        <li>Built the logic for a streamlined ad-serving platform that scaled</li>
                        <li>Educational institutions and online classroom management</li>
                    </ul>
                    <p><strong>Web Content Manager</strong><br>Really Great Company<br>2014 - 2016</p>
                    <ul>
                        <li>Database administration and website design</li>
                        <li>Built the logic for a streamlined ad-serving platform that scaled</li>
                        <li>Educational institutions and online classroom management</li>
                    </ul>
                    <p><strong>Analysis Content</strong><br>Really Great Company<br>2010 - 2014</p>
                    <ul>
                        <li>Database administration and website design</li>
                        <li>Built the logic for a streamlined ad-serving platform that scaled</li>
                        <li>Educational institutions and online classroom management</li>
                    </ul>
                </div> --}}
                <div class="cv-section">
                    <h3>Experience professionel</h3>
                    <p>{{ $candidat->experience_pro}}</p>
                </div>

                <div class="cv-section">
                    <h3>Formation et Diplome</h3>
                    <p>{{ $candidat->formation_diplome}}</p>
                </div>

                <div class="cv-section">
                    <h3>Competence</h3>
                    <p>{{ $candidat->competence}}</p>
                </div>

                <div class="cv-section">
                    <h3>Centre d'interet</h3>
                    <p>{{ $candidat->centre_interet}}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
