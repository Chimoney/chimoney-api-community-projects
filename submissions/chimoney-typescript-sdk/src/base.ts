// interacting with the chimoney's API

// Package to load environment variables from a .env file into process.env
// 
import dotenv from 'dotenv';

// Load environment variables when the SDK is initialized
dotenv.config();

// defined to represent the shape the shape of the configuration object used when initializing the SDK

type Config = {
    apikey: string; // required string for the API key used to authenticate requests
    baseUrl?: string;  // optional string for the base URL of the API (variy depending on the environment e.g production vs development)
};

// Core utility that handles API interactions
// IT will be extended by other classes in the SDK that define specific Chimoney API methods
export class Base {
    // Private properties for API key and base URL
    private readonly apiKey: string; // A private string that holds the API key for authentication
    private readonly baseUrl: string; // A private string for the API's base URL

    // the constructor takes a Config object as an object
    constructor(config: Config) {
        // Use provided config or fallback to environment variables
        // If no base URL is provided in the config, it will fall back to the BASE_URL environment variable
        // If no BASE_URL environment variable is found, it will throw an error
        // If both are provided, it will use the provided baseUrl in the config object
        // If no baseUrl is provided in the config or environment variables, it will throw an error
        const { apikey, baseUrl } = config;

        // Validate the API key
         // if the API key is not provided via the Config object
        // it will attempt tpo load it from the environment variables using process.env.API_KEY
        // THe same applies to the baseUrl, defaulting to process.env.BASE_URL if not provided
        // If no API key is found, it throws an error since an API key is mandatory for requests.
        if (!apikey && !process.env.API_KEY) {
            throw new Error('API key must be provided either in config or environment variables.');
        }

        this.apiKey = apikey || (process.env.API_KEY as string);
        this.baseUrl = baseUrl || (process.env.BASE_URL as string) || ''; // Ensure baseUrl is a string
    }

    // Method to get the base URL
    // This method return the baseUrl. If its not set, it throws an error
    // very crucial to ensure that the API's base url is defined before making requests
    protected getBaseUrl(): string {
        if (!this.baseUrl) {
            throw new Error('Base URL is not defined. Please provide a valid base URL.');
           
        }
        return this.baseUrl;

    }

    // Method to get the API key
    // REturns the stored apikey. This is needed for making authenticated requests to Chimoney's API
    protected getApiKey(): string {
        return this.apiKey;
    }

    // this  method handles all API requests (both GET and POST)
    //Constructs the full URL using the base URL and the provided endpoint, and attaches the API key in the Authorization header
    protected async apiRequest(endpoint: string, options: RequestInit = {}): Promise<any> {
        console.log(`Making request to: ${this.getBaseUrl()}/${endpoint}`);
        console.log(`Using API key: ${this.getApiKey()}`);
        try {
            // sends an HTTP request using fetch and checks the response for errors
            const response = await fetch(`${this.getBaseUrl()}/${endpoint}`, {
                ...options,
                headers: {
                    ...options.headers,
                    'Authorization': `Bearer ${this.getApiKey()}`, // Change this to use this.getApiKey()
                    'Content-Type': 'application/json',
                },
            });
    
            // if the response insn't successful (response.ok is false), it throws an error with the status text and error message from the response body
            if (!response.ok) {
                const errorMessage = await response.text();
                throw new Error(`API request failed: ${response.statusText} - ${errorMessage}`);
            }
            // if the request succeeds, it returns the parsed JSON response
            return await response.json();
        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    }
    

    // POST request method
    // This method performs a POST request to the provided endpoint with the given data

    protected async post(endpoint: string, data: any): Promise<any> {
        // uses the apiRequest method, setting the HTTP method to POST and sending the data in the request body.
        return await this.apiRequest(endpoint, {
            method: 'POST',
            body: JSON.stringify(data),
        });
    }

    // GET request method (optional if needed)
    // This method performs a GET request to the provided endpoint and returns the parsed JSON response.
    protected async get(endpoint: string): Promise<any> {
        // uses apiRequest, but here the method is set to GET
        return await this.apiRequest(endpoint, {
            method: 'GET',
        });
    }
}


// The Base class is designed to serve as a foundation for making API requests with Chimoney's API
// By encapsulating the logic for handling authentication, building request URLs, and error handling
// Provides a solid base that can be extended with more specific API functionality

// Benefits
// strong typing, ts ensures correct types, preventing errors at compile time
// Reusable API request logic: The apiRequest, post and get methods centralize HTTP request logic, making it easy to extend the SDK for different API calls
