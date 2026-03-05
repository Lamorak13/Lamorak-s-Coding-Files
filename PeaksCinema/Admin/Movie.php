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

    button.addTimeButton {
        border: 3px solid black;
        border-radius: 25px;
        padding: 5px;
        font-size: 80%;
        font-weight: bold;
        color: black;
        transition: border 0.5s, padding 0.5s, color 0.5s;
    }

    button.addTimeButton:hover {
        border: 3px solid rgb(18, 141, 172);
        padding: 7px;
        color: black;        
    }

    button.addTimeButton:active {
        background-color: rgb(18, 141, 172);
    } 
    </style>
    <body>
        <main>
            <span id="dayRow"><button type="button" class="timeButton" id="1">10:00 AM</button></span>
            <span>
                <button type="button" class="addTimeButton">+</button>
            </span>
        </main>
        <script>
            const timeButtons = document.querySelectorAll('.timeButton');

            timeButtons.forEach(e => {
                e.addEventListener("click", function() {
                    this.remove();
                })
            })

            const dayRow = document.getElementById("dayRow");
            const addTimeButtons = document.querySelectorAll('.addTimeButton');
            addTimeButtons.forEach(e => {
                e.addEventListener("click", function() {
                    dayRow.innerHTML += '<input type="time"> </input>';
                })
            })
            
        </script>
    </body>
</html>

