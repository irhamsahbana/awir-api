"use strict";

function fruitChop(fruits, cb) {
    console.log("Please wait.. I'll chop these fruits..");
    console.log(fruits);
    console.log("\n");

    // proces chopped disini
    let resultChop = fruits.map((x) => x + "-choped");
    // console.log(resultChop);
    cb(resultChop);
}

function juicer(choppedFruits, cb) {
    console.log("I already have", choppedFruits);
    console.log(
        "Please wait.. I'll blend these chopped fruits in blender...\n"
    );

    const chop = [];
    choppedFruits.forEach((el) => {
        let splitChop = el.split("-");
        chop.push(splitChop[0]);
    });

    let serveJuice = chop.map((x) => {
        x += "-juiced";
        return x;
    });

    cb(serveJuice);
}

// MAIN FUNCTION
function startJuicing() {
    console.log("I wanna make some fruit juices");
    const fruits = ["apple", "orange", "grape"];

    const cbFruitChop = function (choppedFruits) {
        setTimeout(() => {
            console.log("I'm done chopping!", choppedFruits);
            console.log("\n");

            const cbJuicer = function (serveJuice) {
                setTimeout(() => {
                    console.log(`juices ready to serve! here youre juices`);
                    console.log(serveJuice);
                }, "2000");
            };

            juicer(choppedFruits, cbJuicer);
        }, "2000");
    };

    fruitChop(fruits, cbFruitChop);
}

// startJuicing();

// promise version

function fruitChopPromise(fruits) {
    return new Promise(function (resolve, reject) {
        console.log("Please wait.. I'll chop these fruits..");
        console.log(fruits);
        console.log("\n");

        const resultChop = fruits.map((x) => x + "-choped");

        setTimeout(() => {
            resolve(resultChop);
        }, 2000);
    });
}

function juicerPromise(choppedFruits) {
    return new Promise(function (resolve, reject) {
        console.log("I already have", choppedFruits);
        console.log(
            "Please wait.. I'll blend these chopped fruits in blender...\n"
        );

        let chop = [];
        choppedFruits.forEach((el) => {
            let splitChop = el.split("-");
            chop.push(splitChop[0]);
        });

        let serveJuice = chop.map((x) => {
            x += "-juiced";
            return x;
        });

        setTimeout(() => {
            resolve(serveJuice);
        }, 2000);
    });
}

function startJuicingPromise() {
    console.log("I wanna make some fruit juices");
    const fruits = ["apple", "orange", "grape"];

    fruitChopPromise(fruits)
        .then((choppedFruits) => {
            console.log("I'm done chopping!", choppedFruits);
            console.log("\n");

            juicerPromise(choppedFruits)
                .then((serveJuice) => {
                    console.log(`juices ready to serve! here youre juices`);
                    console.log(serveJuice);
                })
                .catch((err) => {
                    console.log(err);
                });
        })
        .catch((err) => {
            console.log(err);
        });
}

// startJuicingPromise();

let obj1 = {
    item: "cheatos",
    harga: 1000,
    waktu: 2000,
};
let obj2 = {
    item: "taro",
    harga: 5000,
    waktu: 2000,
};
let obj3 = {
    item: "wafer",
    harga: 10000,
    waktu: 2000,
};
let obj4 = {
    item: "sprite",
    harga: 8000,
    waktu: 2000,
};
let obj5 = {
    item: "aqua",
    harga: 10000,
    waktu: 2000,
};

function beliPromise(uang, obj) {
    return new Promise((resolver, rejector) => {
        console.log(`Saya pergi membeli ${obj.item} dengan uang ${uang}`);

        setTimeout(function () {
            let kembalian = uang - obj.harga;

            if (kembalian > 0) {
                console.log(
                    `Saya sudah membeli ${obj.item} uang kembaliannya ${kembalian}`
                );
                resolver(kembalian);
            } else {
                // console.log(
                //     `uang gk cukup nih buat beli ${obj.item} uangnya cuma ${uang}`
                // );
                rejector(
                    `uang gk cukup nih buat beli ${obj.item} uangnya cuma ${uang} sedangkan harga ${obj.item} adalah ${obj.harga}`
                );
            }
        }, obj.waktu);
    });
}

const uangDiKantong = 8000;
beliPromise(uangDiKantong, obj1)
    .then((sisa) => {
        beliPromise(sisa, obj2)
            .then((sisa) => {
                beliPromise(sisa, obj3)
                    .then((sisa) => {
                        beliPromise(sisa, obj4)
                            .then((sisa) => {
                                beliPromise(sisa, obj5)
                                    .then((sisa) =>
                                        console.log(`sisa uang ${sisa}`)
                                    )
                                    .catch((err) => {
                                        console.log(err);
                                    });
                            })
                            .catch((err) => {
                                console.log(err);
                            });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            })
            .catch((err) => {
                console.log(err);
            });
    })
    .catch((err) => {
        console.log(err);
    });
