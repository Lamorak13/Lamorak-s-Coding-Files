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
        font-weight: bold;
        font-size: 80%;
        color: black;
        transition: border 0.5s, padding 0.5s, color 0.5s;
    }

    button.addTimeButton:hover {
        border: 3px solid rgb(18, 141, 172);
        padding: 8px;
        color: rgb(18, 141, 172);        
    }

    button.addTimeButton:active {
        background-color: rgb(18, 141, 172);
    } 
    </style>
    <body>
        <main>
            
            <button type="button" class="timeButton" id="1">10:00 AM</button>
            <button type="button" class="addTimeButton">Add Time</button>
        </main>
        <script>
            const timeButtons = document.querySelectorAll('.timeButton');

            timeButtons.forEach(e => {
                e.addEventListener("click", function() {
                    this.remove();
                })
            })


            const addTimeButtons = document.querySelectorAll('.addTimeButton');
            addTimeButtons.forEach(e => {
                e.addEventListener("click", function() {
                    e.innerHTML = <div>hi</div>;
                })
            })
            
        </script>
    </body>
</html>

