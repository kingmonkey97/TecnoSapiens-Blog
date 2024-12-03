-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 18:29:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `publicar2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `author`, `content`, `date`) VALUES
(4, 14, 'admin', 'holo', '2024-12-02 01:25:02'),
(5, 21, 'holo', 'holo', '2024-12-02 14:58:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `media` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `author`, `title`, `content`, `media`, `date`) VALUES
(11, 'admin', 'Los Últimos Avances en Inteligencia Artificial: Innovación y Líderes en el Campo', 'La Inteligencia Artificial (IA) ha experimentado una evolución vertiginosa en las últimas décadas, pasando de ser un concepto teórico en la ciencia ficción a una tecnología disruptiva que está remodelando industrias enteras. Desde su definición inicial como la capacidad de una máquina para realizar tareas que normalmente requieren de inteligencia humana, hasta sus aplicaciones actuales en áreas como la medicina, la automoción y la automatización, los avances en IA siguen sorprendiendo. En este ensayo, exploraremos los últimos avances en IA y cómo diferentes organizaciones y personas están impulsando esta tecnología hacia nuevas fronteras.', 'uploads/674d4eb9ac498-ia.jpeg', '2024-12-02 01:07:53'),
(12, 'admin', 'Avances Recientes en IA', 'Uno de los avances más notables en el campo de la IA ha sido el desarrollo de modelos de lenguaje como los de OpenAI. Modelos como GPT-4 y GPT-3, por ejemplo, son sistemas que pueden entender y generar texto de manera que simulan una conversación humana. Esta tecnología no solo está mejorando los asistentes virtuales, sino que también está abriendo puertas a nuevas aplicaciones en la generación de contenido, la traducción automática, la atención al cliente y hasta la creación de código. A través de grandes redes neuronales y vastos conjuntos de datos, estos modelos han logrado una comprensión y generación de lenguaje que es cada vez más precisa y contextualizada.\r\n\r\nPor otro lado, el campo de la visión por computadora ha dado saltos agigantados gracias a los avances en redes neuronales convolucionales (CNN). Estas redes se utilizan para que las máquinas puedan reconocer, interpretar y clasificar imágenes. Aplicaciones en áreas como la medicina, donde los algoritmos de IA están ayudando a diagnosticar enfermedades como el cáncer, son uno de los ejemplos más impresionantes. Herramientas como Google DeepMind han mostrado cómo la IA puede aprender a realizar diagnósticos más precisos que los de algunos médicos en casos complejos.\r\n\r\nLa IA también ha alcanzado nuevos niveles en la autonomía de vehículos. Los vehículos autónomos, aunque aún en fase de prueba, ya están utilizando IA para navegar de manera segura y eficiente en entornos urbanos. Empresas como Tesla, Waymo (de Google) y otras startups han estado trabajando incansablemente en perfeccionar los algoritmos de IA para garantizar que los vehículos autónomos puedan reconocer obstáculos, predecir el comportamiento de otros conductores y tomar decisiones inteligentes en tiempo real.\r\n\r\nAdemás, los avances en el campo de la IA explicativa están permitiendo que los modelos de IA sean más transparentes. Mientras que en el pasado muchos modelos de IA eran considerados \"cajas negras\" debido a la dificultad para comprender cómo tomaban decisiones, ahora los investigadores están desarrollando herramientas para interpretar y justificar las predicciones de las máquinas, lo cual es clave para la confianza y la adopción generalizada de la IA.', 'uploads/674d4f2f2f1fc-avance.jpg', '2024-12-02 01:09:51'),
(13, 'admin', 'Quiénes Están Impulsando Los Avances En La IA', 'En cuanto a los líderes de la investigación y el desarrollo de la IA, hay algunas figuras y organizaciones destacadas que están marcando el paso en este campo.\r\n\r\nOpenAI: Fundada por Elon Musk, Sam Altman y otros visionarios en 2015, OpenAI ha sido una de las fuerzas más influyentes en la creación de modelos de IA de vanguardia. El desarrollo de GPT-3 y GPT-4 ha puesto a OpenAI en el centro de la atención mundial. Su enfoque en crear IA que beneficie a toda la humanidad ha llevado a importantes debates sobre ética, seguridad y el uso responsable de la tecnología.\r\n\r\nDeepMind: Adquirida por Google en 2014, DeepMind ha sido un pionero en la investigación de IA avanzada, especialmente en el campo de la salud y la resolución de problemas complejos. Uno de sus logros más impresionantes fue la creación de AlphaGo, un sistema de IA capaz de vencer a campeones humanos en el juego de Go, un desafío mucho más complejo que el ajedrez debido a la inmensa cantidad de posibles movimientos. Ahora, DeepMind está aplicando sus avances a la investigación médica, como el diagnóstico de enfermedades o la predicción de estructuras de proteínas.\r\n\r\nTesla y Elon Musk: A través de Tesla, Musk ha sido un defensor de la implementación de IA en los vehículos autónomos, llevando la tecnología de conducción autónoma a los consumidores. La visión de Musk es que los autos autónomos reducirán significativamente los accidentes de tráfico y mejorarán la eficiencia del transporte. Tesla también ha trabajado en la creación de chips personalizados que potencian la IA para el procesamiento de datos en tiempo real.\r\n\r\nIBM Watson: IBM ha estado desarrollando IA aplicada a diversas industrias, desde la salud hasta la banca, con su sistema Watson. Este sistema ha sido utilizado para ayudar en diagnósticos médicos, en la mejora de procesos empresariales y en la optimización de decisiones comerciales. IBM se enfoca en crear soluciones personalizadas para empresas, ayudando a la adopción de la IA en el sector empresarial.\r\n\r\nNVIDIA: Aunque conocida principalmente por sus tarjetas gráficas, NVIDIA también se ha convertido en una de las principales impulsoras del desarrollo de la IA. Su plataforma CUDA ha sido fundamental en la aceleración de los cálculos necesarios para entrenar modelos de IA, y sus unidades de procesamiento gráfico (GPU) son esenciales para la mayoría de los avances en aprendizaje profundo.', 'uploads/674d5008bee40-Elon Musk.jpg', '2024-12-02 01:13:28'),
(14, 'admin', 'Impacto en la Sociedad y el Futuro de la IA', 'A medida que la IA sigue evolucionando, su impacto en la sociedad será cada vez más profundo. Desde la automatización de trabajos hasta la mejora de diagnósticos médicos y la creación de nuevas formas de interacción con la tecnología, la IA está transformando rápidamente el panorama mundial. No obstante, este avance plantea importantes desafíos éticos y sociales. La privacidad, la seguridad de los datos, la toma de decisiones automatizadas y el desplazamiento laboral son solo algunas de las preocupaciones que deben ser abordadas de manera cuidadosa.\r\n\r\nEl futuro de la IA se vislumbra como una era de innovaciones aún más sorprendentes, con sistemas de IA colaborativos y tecnologías más integradas en nuestra vida diaria. Es probable que los próximos años traigan avances en IA explicativa, interfaces cerebro-computadora, y hasta la creación de IA general, un tipo de inteligencia artificial que pueda realizar cualquier tarea cognitiva humana.', 'uploads/674d5064e24f1-impacto.jpeg', '2024-12-02 01:15:00'),
(16, 'admin', 'La Evolución del Software de Código Abierto: Beneficios y Desafíos en el Mundo Moderno', 'El software de código abierto ha pasado de ser una tendencia marginal a convertirse en una parte fundamental del ecosistema tecnológico moderno. Con la creciente adopción de herramientas de código abierto en todos los sectores, desde el desarrollo web hasta la inteligencia artificial, esta modalidad de desarrollo ha demostrado ser una vía para la innovación rápida, la colaboración global y la creación de soluciones personalizadas.\r\n\r\nBeneficios del Software de Código Abierto\r\nColaboración Global: El código abierto fomenta una comunidad de desarrolladores alrededor del mundo, permitiendo que los proyectos evolucionen de manera más rápida y que se resuelvan problemas con mayor eficiencia.\r\nTransparencia y Seguridad: Al ser accesible para cualquier usuario, el código abierto permite que el software sea auditado y mejorado continuamente, aumentando la seguridad.\r\nCostos Reducidos: Muchas veces, el software de código abierto es gratuito o mucho más económico que las soluciones propietarias, lo que lo hace accesible para pequeñas empresas y startups.\r\nFlexibilidad y Personalización: Al tener acceso al código fuente, los usuarios pueden adaptar el software a sus necesidades específicas.\r\nDesafíos del Código Abierto\r\nFalta de Soporte Formal: Aunque existen comunidades activas, la falta de soporte dedicado por parte de empresas puede ser un reto para algunas organizaciones.\r\nProblemas de Compatibilidad: La integración de software de código abierto con sistemas existentes puede ser más compleja en comparación con soluciones propietarias.\r\nCurva de Aprendizaje: Algunos proyectos de código abierto pueden tener una curva de aprendizaje empinada, lo que requiere que los desarrolladores se familiaricen profundamente con el código.\r\nConclusión\r\nEl software de código abierto está cambiando la forma en que pensamos sobre el desarrollo y el uso de aplicaciones, ofreciendo grandes beneficios, pero también presentando desafíos que requieren ser gestionados cuidadosamente. Con el enfoque correcto, el código abierto puede ser una herramienta poderosa para crear soluciones de software innovadoras y económicas.', 'uploads/674d5182db6fc-codigo abierto.jpg', '2024-12-02 01:19:46'),
(17, 'admin', 'El Futuro de la Ciberseguridad: Cómo la Inteligencia Artificial Está Transformando la Protección de Datos', 'A medida que el mundo se vuelve más digital y conectado, la ciberseguridad se ha convertido en un tema de gran preocupación para empresas y usuarios. Con un número creciente de amenazas cibernéticas, desde ransomware hasta phishing y ataques DDoS, la necesidad de soluciones innovadoras nunca ha sido tan urgente. En este contexto, la Inteligencia Artificial (IA) está jugando un papel clave en la transformación de la ciberseguridad, ofreciendo nuevas formas de detectar, prevenir y mitigar riesgos.\r\n\r\nLa IA en la Ciberseguridad: Un Cambio de Paradigma\r\nDetección Proactiva de Amenazas: Tradicionalmente, los sistemas de ciberseguridad se basaban en firmas para identificar amenazas conocidas. Sin embargo, las técnicas de IA, como el aprendizaje automático, permiten que los sistemas aprendan de los datos y detecten comportamientos anómalos o patrones sospechosos en tiempo real, incluso antes de que se desarrollen ataques conocidos.\r\n\r\nAutomatización de la Respuesta a Incidentes: Los sistemas de IA no solo detectan amenazas, sino que también pueden tomar decisiones automáticas sobre cómo responder a incidentes. Desde bloquear direcciones IP sospechosas hasta aislar un dispositivo comprometido, la IA puede reducir significativamente el tiempo de reacción y minimizar el impacto de un ataque.\r\n\r\nAnálisis de Big Data: La ciberseguridad moderna implica el manejo de enormes cantidades de datos. La IA permite procesar y analizar estos datos a una velocidad y precisión que los humanos no podrían alcanzar, mejorando la capacidad de las empresas para identificar vulnerabilidades y defenderse de los ataques más sofisticados.\r\n\r\nProtección Avanzada contra el Phishing: Con el aumento de los ataques de phishing, las herramientas de IA están siendo utilizadas para identificar y bloquear correos electrónicos fraudulentos antes de que lleguen a las bandejas de entrada de los usuarios. Estas herramientas analizan patrones en los correos electrónicos, sitios web y comportamientos para detectar intentos de suplantación de identidad.\r\n\r\nBeneficios y Desafíos de la IA en Ciberseguridad\r\nBeneficios:\r\n\r\nDetección más rápida y precisa: La IA mejora la eficiencia en la detección de amenazas y vulnerabilidades, reduciendo el riesgo de que los ataques pasen desapercibidos.\r\nMejora de la eficiencia operativa: La automatización de tareas repetitivas permite a los equipos de seguridad centrarse en amenazas más complejas.\r\nMayor adaptabilidad: Los sistemas de IA pueden adaptarse rápidamente a nuevas amenazas, mejorando la protección de los datos sin intervención humana.\r\nDesafíos:\r\n\r\nComplejidad y coste: La implementación de soluciones basadas en IA en ciberseguridad puede ser costosa y requerir recursos especializados.\r\nRiesgos de la IA misma: Los atacantes también pueden utilizar IA para llevar a cabo ciberataques más sofisticados, lo que plantea un nuevo conjunto de desafíos.\r\nPrivacidad y ética: La recopilación de grandes cantidades de datos personales y su procesamiento por IA puede generar preocupaciones sobre la privacidad y el uso ético de la información.\r\nEl Futuro de la Ciberseguridad con IA\r\nEl futuro de la ciberseguridad estará marcado por una mayor integración de la IA. Los sistemas de protección no solo serán más inteligentes y rápidos, sino que también serán más predictivos, lo que permitirá a las empresas anticipar y prevenir ataques antes de que ocurran. A medida que los ataques cibernéticos se vuelven más sofisticados, la colaboración entre humanos y máquinas será clave para mantener los datos a salvo.\r\n\r\nLa inteligencia artificial está transformando la ciberseguridad, proporcionando herramientas poderosas para detectar, prevenir y responder a amenazas de manera más rápida y eficiente. Si bien existen desafíos asociados con su implementación, la IA ofrece un potencial significativo para mejorar la protección de los datos y hacer frente a las amenazas cibernéticas cada vez más complejas.', 'uploads/674d51f5c1112-seguridad.jpeg', '2024-12-02 01:21:41'),
(18, 'admin', 'La Revolución del 5G: ¿Cómo Impactará esta Tecnología en el Futuro del Software y la Conectividad?', 'El despliegue de la red 5G está marcando el comienzo de una nueva era en la conectividad global. Con velocidades de descarga y carga mucho más rápidas, una latencia casi nula y una capacidad de conexión simultánea mucho mayor, el 5G promete revolucionar no solo las telecomunicaciones, sino también el mundo del software, las aplicaciones y la Internet de las Cosas (IoT). En este artículo, exploraremos cómo el 5G transformará la forma en que utilizamos la tecnología y lo que significa para el futuro del software.\r\n\r\nLo que el 5G Traerá al Mundo del Software\r\nVelocidades Superiores para el Desarrollo y la Implementación: Las redes 5G permitirán que las aplicaciones y servicios en la nube se ejecuten de manera mucho más eficiente y rápida. Los desarrolladores de software podrán realizar actualizaciones, pruebas y lanzamientos de manera más ágil, aprovechando las altas velocidades de conexión que ofrece esta nueva tecnología.\r\n\r\nDesarrollo de Aplicaciones más Rápidas y Responsivas: La baja latencia de 5G es crucial para aplicaciones que requieren tiempo real, como la realidad aumentada (AR), la realidad virtual (VR) y los videojuegos en línea. Las aplicaciones podrán operar con mayor fluidez y sin interrupciones, proporcionando una experiencia más inmersiva para los usuarios.\r\n\r\nInternet de las Cosas (IoT) a Escala Global: 5G permitirá la conectividad de una enorme cantidad de dispositivos IoT, desde electrodomésticos inteligentes hasta vehículos autónomos. Con la capacidad de conectar millones de dispositivos simultáneamente sin perder velocidad o eficiencia, el 5G acelerará la expansión de las ciudades inteligentes y las soluciones automatizadas.\r\n\r\nTransformación de la Industria del Software Empresarial: El 5G cambiará la forma en que las empresas desarrollan sus soluciones tecnológicas. Desde aplicaciones de análisis de datos en tiempo real hasta la gestión de operaciones en fábricas inteligentes, las empresas podrán aprovechar el 5G para mejorar su productividad, reducir tiempos de inactividad y ofrecer experiencias más personalizadas a sus clientes.\r\n\r\nBeneficios Clave del 5G para el Software\r\nMayor Velocidad de Conexión: Las velocidades ultrarrápidas de 5G permitirán a las aplicaciones y servicios basados en la nube ofrecer resultados inmediatos, mejorando la experiencia del usuario y reduciendo el tiempo de espera.\r\nMayor Capacidad para Dispositivos Conectados: 5G puede manejar más dispositivos simultáneamente, lo que facilita la expansión de tecnologías como IoT y permite aplicaciones que no habrían sido viables en redes más lentas.\r\nBaja Latencia: La latencia casi nula del 5G es esencial para aplicaciones en tiempo real, como los videojuegos online, la telemedicina y las videoconferencias de alta calidad, mejorando la interacción y la productividad.\r\nDesafíos que Acompañan al 5G\r\nInfraestructura Costosa: Aunque el 5G tiene un gran potencial, el costo de desplegar esta red a nivel global es significativo. Las empresas deben invertir en nuevas infraestructuras y actualizar las redes existentes, lo que representa un desafío logístico y financiero.\r\nPreocupaciones por la Seguridad: Con el aumento de dispositivos conectados y la mayor transferencia de datos, los riesgos de seguridad también aumentan. La protección de datos sensibles y la gestión de la privacidad serán cuestiones clave que deberán abordarse con el despliegue del 5G.\r\nDesigualdad en el Acceso: Aunque el 5G promete mejorar la conectividad, la distribución de esta tecnología no será igual en todo el mundo. Las áreas rurales y las regiones en desarrollo podrían enfrentar desafíos para acceder a esta nueva tecnología.\r\nEl Futuro del Software con 5G\r\nEl futuro del software será sin duda una era de mayor velocidad, interactividad y conectividad. Con el 5G, las aplicaciones serán más inteligentes, adaptables y eficientes, permitiendo que los desarrolladores creen soluciones más innovadoras que mejoren todos los aspectos de nuestras vidas, desde la atención médica hasta el entretenimiento y la educación.\r\n\r\nEl impacto del 5G en la industria del software no solo se limitará a las aplicaciones móviles o los servicios en la nube. Las oportunidades son vastas y, a medida que las tecnologías de 5G sigan evolucionando, el software será la clave para desbloquear todo su potencial.\r\n\r\n\r\nEl 5G tiene el potencial de transformar la manera en que interactuamos con la tecnología. Con su capacidad para ofrecer velocidades más rápidas, conectividad más robusta y una mayor capacidad para manejar dispositivos, esta tecnología cambiará radicalmente la forma en que desarrollamos y usamos el software. Aunque existen desafíos, los beneficios de un mundo conectado por 5G son innegables, y el futuro parece prometedor para los desarrolladores y usuarios por igual.\r\n\r\nImagen recomendada: Una visualización futurista que combine redes de telecomunicaciones 5G con dispositivos IoT, mostrando conexiones rápidas y una red densa de información digital fluyendo a través de dispositivos como smartphones, vehículos autónomos y drones.', 'uploads/674d528d6e444-5g.jpg', '2024-12-02 01:24:13'),
(21, 'holo', 'harry potter', 'hhhhhhhhhhhhhhhhh', 'uploads/674e111d88279-Captura de pantalla 2024-03-25 180027.png', '2024-12-02 14:57:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin','moderator') DEFAULT 'user',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`, `updated_at`) VALUES
(3, 'admin', '$2y$10$y.pG0js.Dmd9rNAwTZu6KeUorqbZeEbQd8F81necmuGNqVNKwuVdq', '2024-11-29 10:20:57', 'admin', '2024-11-29 10:20:57'),
(10, 'holo', '$2y$10$XMmsm63cP14hLXgsdVs5c.CD3jJB318MAc0f2zFXR6MP6IW6ZSji.', '2024-12-02 19:56:45', 'user', '2024-12-02 19:57:38');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `author` (`author`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`author`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
