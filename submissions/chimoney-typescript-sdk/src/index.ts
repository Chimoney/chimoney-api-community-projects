import { Base } from "./base"; // Importing the foundational Base class to inherit shared API handling methods
import { applyMixins } from "./utils"; // Importing utility function to apply multiple mixins
import { Payments } from "./payments"; // Importing Payments class to mix payment functionalities into Typicode

/**
 * Typicode Class
 * 
 * This class serves as an entry point for interacting with various payment-related methods.
 * It extends the Base class to inherit core API handling, while mixins are applied to integrate
 * functionality from Payments, allowing Typicode to encapsulate different API modules cohesively.
 */
class Typicode extends Base {} // Extending the Base class to leverage shared API functionalities

// Declaring Typicode implements the Payments interface to integrate the associated payment methods
interface Typicode extends Payments {}

// Applying mixins to combine the functionalities of Base and Payments into Typicode.
// The applyMixins utility function handles the prototype manipulation to ensure
// Typicode can access all methods defined within the Payments class.
applyMixins(Typicode, [Payments]);

// Exporting Typicode as the default module export to allow streamlined importing
// of this combined API handler, enabling easy and unified access to payment functionalities.
export default Typicode;
