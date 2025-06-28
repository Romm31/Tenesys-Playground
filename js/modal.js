var Modal = {
    init: function (modal_id, trigger_id, close_id) {
        let trigger = document.getElementById(trigger_id);
        let modal = document.getElementById(modal_id);
        let btnClose = document.getElementById(close_id);

        if (typeof trigger === undefined || typeof modal === undefined) {
            console.error("Unable to link the elements");
            return;
        }

        // Set click listener for trigger
        trigger.onclick = function () {
            modal.style.display = "flex";
        }

        btnClose.onclick = function () {
            modal.style.display = "none";
        }
    }
}

class ChallengeModal {

    constructor(modal_id, card_class, close_id, solve_id) {
        this.triggers = document.getElementsByClassName(card_class);
        this.modal = document.getElementById(modal_id);
        this.btnClose = document.getElementById(close_id);
        this.btnSolve = document.getElementById(solve_id);
        this.solveForm = document.getElementById("solve-form");
        this.textFlag = document.getElementById("text-flag");

        for (let i = 0; i < this.triggers.length; i++) {
            this.triggers[i].onclick = () => {
                this.modal.style.display = "flex";
                this.solveForm.setAttribute("data-cid", this.triggers[i].getAttribute("data-id"));
                console.log("Challenge Id: " + this.solveForm.dataset.cid);
                let challenge_id = this.triggers[i].dataset.id;
                loadData(modal_id, challenge_id, this.userid);
            }
        }
    }

    init(userid) {
        this.userid = userid;
        console.log("UserID : " + userid);

        this.solveForm.addEventListener("submit", (e) => {
            if (e.preventDefault) e.preventDefault();

            let flag = this.textFlag.value;
            let params = {
                flag: flag,
                cid: this.solveForm.dataset.cid,
                userid: this.userid
            };
            console.log("Params: " + JSON.stringify(params));

            axios.post('solve_challenge.php', params).then((response) => {
                console.log(JSON.stringify(response));
                if (response.status === 200) {
                    this.textFlag.style.color = "green";
                    myToast.showSuccess(response.message, function () {
                        location.reload();
                    });
                } else {
                    this.textFlag.style.color = "red";
                    myToast.showError(response.message, null);
                }
            });

            return false;
        });

        this.btnClose.onclick = () => {
            console.log("Closing Modal");
            this.modal.style.display = "none";
        }
    }
}

function loadData(modal_id, challenge_id, user_id) {
    console.log("Opening " + modal_id + " for #" + challenge_id);
    let challenge_title = document.getElementById("challenge-id");
    challenge_title.innerHTML = "Challenge";

    let challenge_name = document.getElementById("challenge-name");
    let challenge_desc = document.getElementById("challenge-desc");
    let challenge_flag = document.getElementById("text-flag");
    let btnSolve = document.getElementById("btn-solve");

    challenge_name.innerHTML = "";
    challenge_desc.innerHTML = "";
    challenge_flag.value = "";

    let params = {
        cid: challenge_id,
        userid: user_id
    };

    axios.post("get_challenge.php", params)
        .then(function (response) {
            console.log(JSON.stringify(response));

            challenge_name.innerHTML = response.title;

            // ✅ Decode jika description masih string literal JSON
            let desc = response.description;
            try {
                desc = JSON.parse('"' + desc + '"'); // Decode literal \r\n, \t, dll
            } catch (e) {
                console.warn("Deskripsi tidak perlu decode JSON.");
            }

            // ✅ Ubah \r\n atau \n atau \r jadi <br>
            challenge_desc.innerHTML = desc.replace(/\r\n|\r|\n/g, "<br>");

            if (response.isSolved.toString() === "true") {
                btnSolve.style.display = "none";
                challenge_flag.style.display = "none";
            } else {
                btnSolve.style.display = "block";
                challenge_flag.style.display = "block";
            }
        });
}
