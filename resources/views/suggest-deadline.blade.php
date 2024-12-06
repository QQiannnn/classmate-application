<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggest Deadline</title>
    <script>
        // JavaScript to handle dynamic dropdowns
        function handleTypeChange() {
            var type = document.getElementById('type').value;
            if (type === 'assignment') {
                document.getElementById('assignment_type_div').style.display = 'block';
                document.getElementById('exam_type_div').style.display = 'none';
            } else if (type === 'exam') {
                document.getElementById('exam_type_div').style.display = 'block';
                document.getElementById('assignment_type_div').style.display = 'none';
            } else {
                document.getElementById('assignment_type_div').style.display = 'none';
                document.getElementById('exam_type_div').style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <form action="{{ route('suggest.deadline') }}" method="POST">
        @csrf
        <label for="type">Type:</label>
        <select id="type" name="type" onchange="handleTypeChange()">
            <option value="">Select Type</option>
            <option value="assignment">Assignment</option>
            <option value="exam">Exam</option>
        </select><br>

        <div id="assignment_type_div" style="display:none;">
            <label for="assignment_type">Assignment Type:</label>
            <select name="assignment_type">
                <option value="lab">Lab</option>
                <option value="individual">Individual</option>
                <option value="group_project">Group Project</option>
            </select><br>
        </div>

        <div id="exam_type_div" style="display:none;">
            <label for="exam_type">Exam Type:</label>
            <select name="exam_type">
                <option value="quiz">Quiz</option>
                <option value="midterm">Midterm Exam</option>
                <option value="final">Final Exam</option>
            </select><br>
        </div>

        <!-- Subject Dropdown -->
        <label for="subject_id">Subject:</label>
        <select name="subject_id" id="subject_id">
            <option value="">Select Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select><br>

        <button type="submit">Generate Suggested Deadline</button>
    </form>

    @isset($generated_text)
        <h3>Suggested Deadline:</h3>
        <p>{{ $generated_text }}</p>
    @endisset
</body>
</html>
