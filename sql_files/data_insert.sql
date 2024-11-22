INSERT INTO user_role (role) VALUES ('Admin');
INSERT INTO user_role (role) VALUES ('User');

INSERT INTO user (first_name,last_name,email,password,user_role)
VALUES('Admin','Account','admin@admin.com','123',1);

INSERT INTO user (first_name,middle_name,last_name,email,password,user_role)
VALUES('Anthony','Jose','Perez','anthony@jose.com','anthony',2);

INSERT INTO payment_detail (user_id,card_number,expiration_date,cvv)
VALUES(2,'4000 1234 5678 9010','2024-12-01','123');

INSERT INTO category (category) VALUES ('Electronics');

INSERT INTO product (name, description, price, category, images)
VALUES ('16-inch MacBook Pro - Space Gray',
        'Apple M1 Max chip with 10-core CPU, 32-core GPU, and 16-core Neural Engine
        64GB unified memory
        1TB SSD storage
        16-inch Liquid Retina XDR display
        Three Thunderbolt 4 ports, HDMI port, SDXC card slot, MagSafe 3 port
        140W USB-C Power Adapter
        Backlit Magic Keyboard with Touch ID - US English.',
        3899.00,
        1,
        "images/pro.jpg|images/mac.jpg|images/macbook.jpeg"
        );

INSERT INTO product (name, description, price, category, images)
VALUES ('iPhone 16 Pro Max ',
        'Super Retina XDR Display with ProMotion, 6.7 inch(diagonal) all-screen OLED display
        Apple A15 Bionic Chip, New 6-core CPU with 2 performance and 4 efficiency stores 
        New 5-core GPU, New 16-core Neural Engine
        512GB Internal Storage, 6GB RAM
        Camera - 12 MP, f/1.5, 26mm (wide), 1.9µm, dual pixel PDAF, sensor-shift OIS',
        1399.00,
        1,
        "images/ipho.png|images/phnee.png|images/foto.png"
        );

INSERT INTO product (name, description, price, category, images)
VALUES ('Samsung Galaxy S24 Ultra 5G',
        'Octa-core (1x2.9 GHz Cortex-X1 & 3x2.80 GHz Cortex-A78 & 4x2.2 GHz Cortex-A55) - International
        OS - Android 11, One UI 3.1
        512GB Internal Storage, 16GB RAM
        Camera - 108 MP, f/1.8, 24mm (wide), 1/1.33", 0.8µm, PDAF, Laser AF, OIS
        10 MP, f/4.9, 240mm (periscope telephoto), 1/3.24", 1.22µm, dual pixel PDAF, OIS, 10x optical zoom
        10 MP, f/2.4, 72mm (telephoto), 1/3.24", 1.22µm, dual pixel PDAF, OIS, 3x optical zoom
        12 MP, f/2.2, 13mm (ultrawide), 1/2.55", 1.4µm, dual pixel PDAF, Super Steady video',
        1249.00,
        1,
        "images/21.jpg|images/s.png|images/5g.png"
        );

INSERT INTO product (name, description, price, category, images)
VALUES ('Lenovo ThinkPad X1 Carbon Gen 9 (14" Intel)',
        'Processor - 11th Gen Intel® Core™ i7-1165G7 Processor (2.80 GHz, up to 4.70 GHz with Turbo Boost, 4 cores, 8 threads, 12 MB cache)
        OS - Windows 11 Pro (64-bit)
        Main Memory - 16GB LPDDR4X 4266MHz Soldered
        Mass Storage - 1TB PCIe SSD
        Keyboard - Illuminated keyboard, fingerprint scanner, US',
        2467.00,
        1,
        "images/X1.jpg|images/len.jpg|images/lenovo.png"
        );

INSERT INTO product (name, description, price, category, images)
VALUES ('BEATS STUDIO 3 WIRELESS',
        'Sound - Noise Cancelling continuously pinpoints, isolates, and cancels exterior noise in real time to play sound the way it was intended
        Design - Over-ear headphones, Advanced  venting to aid noise cancelling technology, Ergonomic pivoting ear cups, Height: 7.2 in /18.4 cm, Weight: 9.17 oz / 260 g
        Connectivity - Class 1 Bluetooth® via the Apple W1 chip, Micro USB port, Android compatible
        Power - Up to 22 hours of battery life with noise cancelling on; up to 40 hours of battery life with noise cancelling off
        In the box - Beats Studio3 Wireless headphones, Carrying Case, 3.5mm RemoteTalk cable, Universal USB charging cable',
        349.95,
        1,
        "images/beats.png|images/bydre.png|images/studio.png"
        );