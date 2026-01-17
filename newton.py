def newton_raphson(f, df, x0, tol=1e-7, max_iter=100):
    """
    Implementación del método de Newton-Raphson.
    
    f: Función a la que buscamos la raíz.
    df: Derivada de la función f.
    x0: Estimación inicial.
    tol: Tolerancia (error máximo permitido).
    max_iter: Número máximo de iteraciones.
    """
    xn = x0
    for i in range(max_iter):
        fxn = f(xn)
        dfxn = df(xn)
        
        # Evitar división por cero
        if abs(dfxn) < 1e-12:
            print("La derivada es demasiado pequeña. El método falló.")
            return None
            
        # Aplicar la fórmula
        xn_siguiente = xn - fxn / dfxn
        
        # Verificar si hemos alcanzado la tolerancia
        if abs(xn_siguiente - xn) < tol:
            print(f"Raíz encontrada en {i+1} iteraciones.")
            return xn_siguiente
            
        xn = xn_siguiente
        
    print("Se alcanzó el máximo de iteraciones sin converger.")
    return xn

# --- Ejemplo de uso ---
# Pedir al usuario el número del que quiere encontrar la raíz cuadrada
n = float(input("Ingresa el número del que deseas encontrar la raíz cuadrada: "))

f = lambda x: x**2 - n
df = lambda x: 2*x

estimacion_inicial = 1.0
raiz = newton_raphson(f, df, estimacion_inicial)

print(f"El resultado aproximado es: {raiz}")