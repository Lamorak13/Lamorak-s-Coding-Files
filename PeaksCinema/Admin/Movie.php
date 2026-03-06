<!DOCTYPE html>
<html>
    <style>

    /* Timeslot Buttons (e.g. "10:00 AM") */
    button.timeButton {
        border: 3px solid black;
        border-radius: 25px;
        padding: 5px;
        font-weight: bold;
        color: black;
        transition: border 0.5s, color 0.5s;
    }
    
    button.timeButton:hover {
        border: 3px solid #ff4d4d;
        color: #ff4d4d;
    }

    button#addDateButton {
        border: 3px solid black;
        border-radius: 25px;
        padding: 5px;
        font-size: 80%;
        font-weight: bold;
        color: black;
        transition: border 0.5s, padding 0.5s, color 0.5s;
    }

    button#addDateButton:hover {
        border: 3px solid rgb(18, 141, 172);
        padding: 7px;
        color: black;        
    }

    button#addDateButton:active {
        background-color: rgb(18, 141, 172);
    }

    #addDateMenu {
        visibility: hidden;
    }

    </style>
    <body>
        <main>
            <span id="dayRow"><button type="button" class="timeButton" id="1">10:00 AM</button></span>
            <span>
                <button type="button" id="addDateButton">Add New Date(s)</button>
            </span>
            <div id="addDateMenu">
                <p>Start Date: <input type="date"></p>
                <p>End Date: <input type="date"> <span style="color: grey;">(optional)</span></p>
                <button type="button" id="saveDateButton">Add</button>
            </div>
        </main>
        <script>
            const timeButtons = document.querySelectorAll('.timeButton');

            timeButtons.forEach(e => {
                e.addEventListener("click", function() {
                    this.remove();
                })
            })

            const addDateButton = document.getElementById('addDateButton');
            const addDateMenu = document.getElementById('addDateMenu');
            addDateButton.addEventListener("click", function() {
                addDateMenu.style.visibility = 'visible';
            })

            const saveDateButton = document.getElementById('saveDateButton');
            saveDateButton.addEventListener("click", function() {
                alert("added");
                addDateMenu.style.visibility = 'hidden';
            })
            
        </script>
    </body>
</html>

