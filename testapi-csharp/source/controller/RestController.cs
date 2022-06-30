using System;
using System.Text;
using System.Net;
using System.Threading.Tasks;

using System.Net.Http;

namespace Examen2.controller
{
    // this class is used to handle the REST calls
    // it allows an optional body to be sent with the request
    // that body is a JSON string
    // the response can be empty, a JSON string
    // and allow the following verbs: GET, POST, PUT, DELETE
    public class RestController
    {
        public string Verb { get; set; }
        public string Body { get; set; }

        public string Url { get; set; }

        private static readonly HttpClient client = new HttpClient();

        public RestController(string url, string verb, string body)
        {
            this.Url = url;
            this.Verb = verb;
            this.Body = body;
        }

        // async request to the server (async method [Response])
        public async Task<Response> DoRequest()
        {

            try
            {
                Response response = new Response();
                // switch verb
                HttpResponseMessage responseMessage;
                switch (Verb)
                {
                    // if get
                    case "GET":
                        // get response
                        responseMessage = await client.GetAsync(Url);
                        break;
                    // if post
                    case "POST":
                        // get response
                        responseMessage = await client.PostAsync(Url,
                         new StringContent(Body, Encoding.UTF8, "application/json"));
                        break;
                    // if put
                    case "PUT":
                        // get response
                        responseMessage = await client.PutAsync(Url, new StringContent(Body, Encoding.UTF8, "application/json"));
                        break;
                    // if delete
                    case "DELETE":
                        // get response
                        responseMessage = await client.DeleteAsync(Url);
                        break;

                    default:
                        throw new Exception("Invalid verb");
                }

                //responseMessage = await client.SendAsync(request);
                // get response
                response.Body = await responseMessage.Content.ReadAsStringAsync();
                // get status code
                response.StatusCode = responseMessage.StatusCode;

                // return response
                return response;
            }
            catch (HttpRequestException e)
            {
                // log the exception
                Console.WriteLine("\nException Caught!");
                Console.WriteLine("Message :{0} ", e.Message);
                return new Response{
                    StatusCode = HttpStatusCode.InternalServerError,
                    Body = "Error" + e.Message
                };
            }
            catch (ArgumentNullException e)
            {
                // log the exception
                Console.WriteLine("\nException Caught!");
                Console.WriteLine("Message :{0} ", e.Message);
                return new Response{
                    StatusCode = HttpStatusCode.InternalServerError,
                    Body = "Error" + e.Message
                };
            }
            catch (Exception e)
            {
                return new Response() { Body = e.Message, StatusCode = HttpStatusCode.InternalServerError };
            }
        }


        // static async methods for the different verbs
        // for get and delete, the body is not used
        // for post and put, the body is a JSON string
        public static async Task<Response> Get(string url)
        {
            try
            {
                return await new RestController(url, "GET", "").DoRequest();
            }
            catch (Exception e)
            {
                Response response = new Response
                {
                    Body = e.Message,
                    StatusCode = System.Net.HttpStatusCode.InternalServerError
                };
                return response;
            }
        }
        public static async Task<Response> Post(string url, string body)
        {
            try
            {
                return await new RestController(url, "POST", body).DoRequest();

            }
            catch (Exception e)
            {
                Response response = new Response
                {
                    Body = e.Message,
                    StatusCode = System.Net.HttpStatusCode.InternalServerError
                };
                return response;
            }
        }
        public static async Task<Response> Put(string url, string body)
        {
            try
            {
                return await new RestController(url, "PUT", body).DoRequest();
            }
            catch (Exception e)
            {
                Response response = new Response
                {
                    Body = e.Message,
                    StatusCode = System.Net.HttpStatusCode.InternalServerError
                };
                return response;
            }
        }
        public static async Task<Response> Delete(string url)
        {
            try
            {
                return await new RestController(url, "DELETE", "").DoRequest();
            }
            catch (Exception e)
            {
                Response response = new Response
                {
                    Body = e.Message,
                    StatusCode = System.Net.HttpStatusCode.InternalServerError
                };
                return response;
            }
        }

        // the response class
        // it contains the response body and the response code
        public class Response
        {
            public string Body { get; set; }
            public HttpStatusCode StatusCode { get; set; }

            public Response()
            {
                Body = string.Empty;
                StatusCode = HttpStatusCode.OK;
            }
        }
    }
}
