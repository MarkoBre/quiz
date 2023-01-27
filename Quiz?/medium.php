<?php
const HEADING_TAG = 'h2';
const BREAKING_TAG = "<br />";
const PARAGRAPH_TAG = 'p';
const LABEL_TAG = 'label';

/*
 * Make function that renders tags to keep the code
 * clean and seperate presentation logic and
 * application logic
 */
function renderTag($tag, $content) {
    echo '<' . $tag . '>' . $content . '</' . $tag . '>';
}
class Quiz
{
    private $answers;
    private $correctAnswer;
    private $question;

    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    public function fetchData()
    {
        // Initialise new cURL session
        $ch = curl_init();
        $baseUrl = 'https://the-trivia-api.com/api/questions';
        $query = '?limit=1&categories=history,science,geography&difficulty=medium&region=RS';
        // Set URL and other options
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $query);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        $result = json_decode($result);
        // Check for errors
        if (curl_errno($ch)) {
            echo "jbg" . curl_error($ch);
        } else {
            // Insert data from quiz API into properties
            $this->answers = $result[0]->incorrectAnswers;
            $this->answers[] = $result[0]->correctAnswer;
            $this->correctAnswer = $result[0]->correctAnswer;
            $this->question = $result[0]->question;
            // Close the connection and free up the system resources
            curl_close($ch);
        }
    }
    public function startQuiz()
    {
        if (
            isset($this->answers) && !empty($this->answers) &&
            isset($this->question) && !empty($this->question)
        ) {
            renderTag (HEADING_TAG, $this->question);
            // Privremen kurac keva krava
            for ($i=0; $i < 3; $i++) {
                echo BREAKING_TAG;
            }
            foreach ($this->answers as $answer) {
                // Print out the questions
                echo '<input type="radio" id="answer" name="answer" value='.'"'.$answer.'">';
                renderTag(LABEL_TAG, $answer);
                echo BREAKING_TAG;
            }
        } else {
            echo 'mrs ispocetka';
        }
    }

    public function checkAnswer($answer)
    {
        if ($answer === $this->correctAnswer) {
            return true;
        }
        return false;
    }

    public function handleSubmit()
    {
        if (isset($_POST['answer'])) {
            if ($this->checkAnswer($_POST['answer'])) {
                echo "Correct!";
            }
        }
    }
}
$keva = new Quiz;
$keva->fetchData();
// Pa majmune glupi svaki put daje random pitanja
// samo treba da se runuje svaki put kad ide submit
?><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kviz za debile</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/general.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>

        <form action="checkAnswer.php" method="post" id="quizForm">
            <?php print $keva->startQuiz(); ?>
            <input type="submit" value="submit" id="submit">
        </form>

    </main>

    <script>
    // Step 2: Get the correct answer from a PHP function
    var correctAnswer = <?php echo json_encode($keva->getCorrectAnswer()); ?>;

    // Step 3: Handle the form's submit event
    document.getElementById("quizForm").addEventListener("submit", function(event) {

        // Step 4: Prevent the default action of the form (which is to refresh the page)
        event.preventDefault();

        // Step 5: Get the user's answer
        var userAnswer = event.target.answer.value;

        // Step 6: Check the user's answer
        checkAnswer(userAnswer);
    });

    function checkAnswer(userAnswer) {
        if (userAnswer === correctAnswer) {
            // Step 7: Show "Correct!" message
            alert("Correct!");
        } else {
            // Step 8: Show "Incorrect. Please try again." message
            alert("Incorrect. Please try again.");
        }
    }
    </script>

</body>

</html>