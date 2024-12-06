<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Deadline</title>
    <script>
        function toggleTypeFields() {
            const type = document.getElementById('type').value;
            const assignmentTypeDiv = document.getElementById('assignment_type_div');
            const examTypeDiv = document.getElementById('exam_type_div');

            // Hide both dropdowns by default
            assignmentTypeDiv.style.display = 'none';
            examTypeDiv.style.display = 'none';

            // Show the appropriate dropdown based on the type selected
            if (type === 'assignment') {
                assignmentTypeDiv.style.display = 'block';
            } else if (type === 'exam') {
                examTypeDiv.style.display = 'block';
            }
        }

        window.onload = toggleTypeFields; // Call this function when the page loads
    </script>
</head>
<body>
    <h1>Generate Suggested Deadline</h1>

    <form action="{{ route('suggest-deadline') }}" method="POST">
        @csrf
        <div>
            <label for="type">Type</label>
            <select name="type" id="type" onchange="toggleTypeFields()">
                <option value="assignment">Assignment</option>
                <option value="exam">Exam</option>
            </select>
        </div>

        <div>
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>  <!-- Assuming 'name' field for the subject -->
                @endforeach
            </select>
        </div>

        <!-- Assignment Type Dropdown (shown only if type = assignment) -->
        <div id="assignment_type_div" style="display: none;">
            <label for="assignment_type">Assignment Type</label>
            <select name="assignment_type" id="assignment_type">
                <option value="lab">Lab</option>
                <option value="individual">Individual</option>
                <option value="group_project">Group Project</option>
            </select>
        </div>

        <!-- Exam Type Dropdown (shown only if type = exam) -->
        <div id="exam_type_div" style="display: none;">
            <label for="exam_type">Exam Type</label>
            <select name="exam_type" id="exam_type">
                <option value="quiz">Quiz</option>
                <option value="midterm">Midterm</option>
                <option value="final">Final</option>
            </select>
        </div>

        <div>
            <button type="submit">Generate Deadline</button>
        </div>
    </form>

</body>
</html>
