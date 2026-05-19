# Custom PHP MVC Framework

A foundational web framework built completely from scratch in PHP. This project exists to demystify the "magic" of modern enterprise frameworks by reverse-engineering the underlying mechanics of routing, controllers, and HTTP request handling.

## 🛠️ Core Architecture



*   **Custom Routing Engine:** Resolves incoming request URIs and maps them to explicit controller actions without relying on third-party packages.
*   **Decoupled MVC Pattern:** Enforces a strict separation of concerns among data models, rendering views, and application logic.
*   **Zero Dependencies:** Built using native PHP components to ensure absolute visibility into the execution lifecycle.

## ⚡ Execution Pipeline

### 1. Bootstrapping
*   **Logic:** Every single request is intercepted and routed through a single entry point to normalize environment initialization.
*   **Command:** Directs web server traffic to `public/index.php`.
*   **Analogy:** The main security checkpoint at a secure facility. No one enters the grounds via side doors; every visitor must pass through the front gate to be verified and logged.

### 2. Route Matching
*   **Logic:** The URL string is parsed, sanitized, and matched against an internal registry array of defined paths.
*   **Command:** `$router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);`
*   **Analogy:** A sorting conveyor belt at a logistics hub. Packages are scanned for their destination zip codes and diverted down the exact structural track built for them.

### 3. Controller Dispatching
*   **Logic:** Instantiates the target controller class and executes the designated method, passing along any extracted route parameters.
*   **Command:** `call_user_array([$controllerInstance, $action], $params);`
*   **Analogy:** A dispatcher assigning a job to a specific specialist. The specialist handles the heavy lifting, processes the payload, and hands back the final output.