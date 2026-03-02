## Framework used

- [Laravel 8.X](https://laravel.com/docs/8.x)
- [Bootstrap 5.X](https://getbootstrap.com/docs/5.0/getting-started/introduction/)


## Server Requirements

- PHP >= 7.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Testing

- We want testable softwares. Most parts of the software in the previous version 1.x were covered by tests. Lets cover version 2.x as well. You also can contribute by writing test case!
- To run Feature and Unit Tests run following commands:

    ```sh
    $ docker exec -it app sh
    // Inside container shell
    :/# php artisan test
    ```

## Features yet to be migrated from v1.X to v2.X
Following features that exist in v1.X will be added in v2.X as well in future.

- Stripe payment
- Messaging
- Managing library
- Managing Income and Expenses
- Mass student and teachers export and import.
- Printing reports
- Managing certificates.
- Supported other languages (Spanish, ...).

## How to Start
#### Document instruction

With the improved Docker setup, you will get:
- Nginx
- PHP 7.4
- MySQL 5.7

### Steps to install:

### INSTALL NEEDED PACKAGES
1. Install first the docker go to this link "https://www.docker.com/products/docker-desktop/" you can download docker windows or using linus depende sa gamit niyong device.
2. After ma download open niyo yung docker installer and connect niyo ung gmail and github niyo.
3. Mag da direct kayo sa docker app after niyo ma connect yung gmail or github niyo.
4. After that open niyo ung POWER SHELL OR CMD niyo then run niyo itong command : 
  
    "docker --version" then ito sunod "docker compose version"

    To verify if the docker is running run niyo itong command : 
   
    "docker info" 

### INSTALL AND RUN PROGRAM

1. Clone or download the repository.
2. Create **purify** folder in `storage/app/` directory. (IF WALA PA)
3. Run `cp .env.example .env`.
4. Run `docker-compose up -d`.
5. Run `docker exec -it db sh`. Inside the shell, run:

Once inside the shell run this :

            "mysql -u root -p"

then type : root

Then run following commands:

    ```sql
    mysql> SHOW DATABASES;
    mysql> GRANT ALL ON unifiedtransform.* TO 'unifiedtransform'@'%' IDENTIFIED BY 'secret';
    mysql> FLUSH PRIVILEGES;
    mysql> EXIT;
    ```
6. Finally, exit the container by running `exit` in the container shell.

Type this command to check if the docker is running : docker ps
You see all the files saying "UP"

7. Run `docker exec -it app sh`. Inside the shell, run following commands:

    ```sh
    :/# composer install
    :/# php artisan key:generate
    :/# php artisan config:cache
    :/# php artisan migrate:fresh --seed
    ```

    Then exit from the container.
8. Visit **http://localhost:8080**. Admin login credentials:

    - Email: manilyndelacuadra@mcs.lms.com
    - Password: password

## Steps to follow:
Please carefully follow the steps to setup the school.

**Role: Admin**

**School Dashboard**

### 1. Create a School Session:
After logging in for the first time, you will see following message at the top nav bar.

To create a new session, go to **Academic Settings** page.

#### Academic Settings page:

Successful creation of session using following form will display success message:

### 2. Create a Semester
Now create a semester. A semester duration usually is 3 - 6 months.

### 3. Create classes
Now create classes. Give common names such as: **Class 1** or **Class 11 (Science)**.


### 4. Create sections
Now create sections for each classes. Give section's name (e.g.: Section A, Section B), room number and assign them to respective class.


### 5. Create Courses
Now create courses and assign them to respective semester and class.


### 6. Set attendance type
Attendance can be maintained in two ways: 1. By section, 2. By course. Stick to one type for a semester. Default: **By section**.

### 7. Add teachers
Now add teachers.


### 8. Assign teacher
Now assign teachers to semester, class, section, and course.


### 9. Add students
Now add students and assign them to class, and section.


### 10. View added teachers and students
Now browse to **View Teachers** and **View Students** pages.


### 11. View student and teacher profile
Now browse to **Profile** from student and teacher list.


### 12. View and Edit Classes and Sections
Now go to **Classes**. Here you can view all classes and their respective sections, syllabi, and courses. Classes, sections, and courses can be edited from here.

### 13. Create Grading Systems
Now create grading system for each class and a semester.

### 14. View Grading Systems
Now browse to created Grading Systems.

### 15. Add and view Grading System Rules
Now add rules to the grading system and browse them.


### 16. Add Notices
Admin can add notice. Right now, notices can be written using a rich text editor.


### 17. Create Events
Events can be created inside a calendar. Click and drag on a date or time period to prompt the input box. An already created event can be **deleted** by clicking on the event.


### 18. Create and view Routines
Routines can be created for each class and section.


### 19. Add Syllabi
Syllabus for each class and course can be added. Admin can view them from **Classes** page. Syllabus can be downloaded.


### 20. Browse by Sessions
You can browse previous sessions like a snapshot. This mode is **Read only**. Nobody should be able to change the previous sessions' data.


### 21. Allow Teachers to submit Final Marks
Submitting final marks of a semester should be controlled. By enabling this feature, it is possible to open a Mark Submission Window for a short time period. **Default: Disallowed**.

### 22. Promote students
Students can only be promoted to a new class and section when a new Session along with its classes and sections are created.


**Role: Teacher**

**Teacher's dashboard**


### 1. View assigned courses
Teachers can manage their assigned courses from this page. From this page, teacher can do following:

- Take and view attendance
- View Syllabus
- Create and view Assignment
- Give Marks
- Message Students (Available in v1.X. Will be added in v2.X as well).


### 2. Take attendance
Teacher can take attendance for a section or a course (attendance type set by Admin).


### 3. View attendance
Teacher can view attendance.


### 4. View syllabus
Teacher can view and download syllabus.


### 5. Create assignment
Teacher can create assignment for an assigned course by uploading files.


### 6. View assignments
Teacher can view and download created assignments.


### 7. Create Exams
Before giving marks, teacher needs to create exams and set their rules. Don't have to create all the exams at a time. (Admin can also create exams on behalf of teachers).


### 8. View created exams
Teacher can view their created exams.

### 9. Add, edit and view exam rules
Teacher can add, edit, and view exam rules.


### 10. Give marks
Teacher can give marks after creating exams. Clicking on the exam names will lead to associated exam rules.

### 11. Submit Final Marks
When the Grade submission window is open, teacher can submit final marks. Calculated marks will be generated based on all exams' marks. Final marks should be in **between** the marks set in the grade rules.

If final marks is submitted, a message will be shown in place of submit button in **Give Marks** page.


### 12. View Final Results
Teachers can view final results and calculated grades for a semester, class, section, and course based on their created grade rules.

**Role: Student**

**Student dashboard**

### 1. View attendance
A student can view his/her attendance.

### 2. View courses
A student can view his/her courses that are assigned in his/her class. From here, a student can do following:

- View Marks
- View Syllabus
- View Assignments

### 3. View Marks
A student can view marks, final results and grade for a course.

### 4. View and download Syllabus
Students can view and download syllabi of their courses just like their teachers.

### 5. View and download assignments
Students can view and download assignments of their courses just like their teachers.

### 6. View routine
Students can view their class and section routine just like their admin/teachers.


