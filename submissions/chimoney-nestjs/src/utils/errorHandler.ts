import { HttpStatusCode } from 'axios';

class HttpException extends Error {
  /**
   * Create custom error
   *
   * @param {*} message Error message for request response
   * @param {number} statusCode HTTP status code. Default is 400
   */
  status: number;
  constructor(message, statusCode) {
    super(message);
    this.name = this.constructor.name;
    this.status = statusCode || 400;
  }
}

/**
 * Handle and format errors.
 *
 * @param {Error} error - The error to be handled.
 * @returns {object} An object containing error message and status code.
 */
const errorHandler = (error) => {
  const message = error.response ? error.response.data : error.message;
  const status = error?.response?.status
    ? error.response.status
    : error.code || HttpStatusCode.InternalServerError;
  return {
    error: message,
    status,
  };
};

/**
 * Handle and format successful responses.
 *
 * @param {object} response - The HTTP response object.
 * @returns {object} An object containing response data and status code, or an error object.
 */
const successHandler = (response) => {
  // Check if the response status indicates success (e.g., status code 200)
  if (!String(response.status).startsWith('2')) {
    // Return the response data and status if the request was successful
    return { data: response.data, status: response.status };
  } else {
    // Handle non-200 status codes (e.g., server errors)
    return errorHandler({ error: response }); // Pass the response to the error handler
  }
};

export { HttpException, errorHandler, successHandler };
