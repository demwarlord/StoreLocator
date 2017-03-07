import * as Module1 from "./moduleone";
import * as Module2 from "./moduletwo";

export = class Main {

    constructor() {
        console.log('elo');
    }

    start() {
        let m1 = new Module1.ModuleOne();
        let m2 = new Module2.ModuleTwo();

        m1.sayHelloTo("David Wesst");
        m2.sayHelloTo("David Wesst");
    }
}
