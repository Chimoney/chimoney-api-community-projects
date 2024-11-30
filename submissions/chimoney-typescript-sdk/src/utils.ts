/**
 * Mixes in properties and methods from multiple base classes into a derived class.
 * 
 * This function iterates over the provided base classes, copying each of their properties 
 * and methods to the derived class prototype. This allows the derived class to inherit 
 * functionalities from multiple classes, effectively implementing a form of multiple inheritance.
 *
 * @param derivedCtor - The constructor of the derived class that will receive the properties and methods.
 * @param baseCtors - An array of constructors of the base classes from which properties and methods will be copied.
 */
export function applyMixins(derivedCtor: any, baseCtors: any[]) {
    baseCtors.forEach(baseCtor => {
        // Loop through all properties and methods of the current base class prototype
        Object.getOwnPropertyNames(baseCtor.prototype).forEach(name => {
            // Assign each property and method to the derived class's prototype
            derivedCtor.prototype[name] = baseCtor.prototype[name];
        });
    });
}
