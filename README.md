## Open eClass 2.3

Το repository αυτό περιέχει μια __παλιά και μη ασφαλή__ έκδοση του eclass.
Προορίζεται για χρήση στα πλαίσια του μαθήματος
[Προστασία & Ασφάλεια Υπολογιστικών Συστημάτων (ΥΣ13)](https://ys13.chatzi.org/), __μην τη
χρησιμοποιήσετε για κάνενα άλλο σκοπό__.


### Χρήση μέσω docker
```
# create and start (the first run takes time to build the image)
docker-compose up -d

# stop/restart
docker-compose stop
docker-compose start

# stop and remove
docker-compose down -v
```

To site είναι διαθέσιμο στο http://localhost:8001/. Την πρώτη φορά θα πρέπει να τρέξετε τον οδηγό εγκατάστασης.


### Ρυθμίσεις eclass

- Database
  - Host : `db`
  - User : `root`
  - Password : `1234`
- Ρυθμίσεις συστήματος
  - URL του Open eClass : `http://localhost:8001/` (προσοχή στο τελικό `/`)
  - Όνομα Χρήστη του Διαχειριστή : `drunkadmin`


## 2020 Project 1

Εκφώνηση: https://ys13.chatzi.org/assets/projects/project1.pdf


### Μέλη ομάδας

- 1115201700028, Ιωάννης Δαρίδης
- 1115201600268, Παντελεήμων Μαλέκας

### Report

Συμπληρώστε εδώ __ένα report__ που
- Να εξηγεί τι είδους αλλαγές κάνατε στον κώδικα για να προστατέψετε το site σας (από την κάθε επίθεση).

### Αλλαγές για προστασία του site

  ### SQL Injection
  Για να προστατέψουμε το site μας από SQL injections, εστιάσαμε στα δυο παραδείγματα που είδαμε στην τάξη. Από τα SQL injections της πρώτης μορφής, δηλαδή τα σημεία όπου μπορεί ένας attacker να προσθέσει SQL κώδικα μέσω user input, βρήκαμε ελάχιστες περιπτώσεις. Αυτό διότι από ό,τι είδαμε τα σημεία αυτά ήταν συνήθως ήδη προστατευμένα. Τα ελάχιστα μέρη όπου δεν ίσχυε αυτό προστατεύθηκαν από εμάς. Από τα SQL injections της δεύτερης μορφής, δηλαδή τα σημεία όπου μπορεί κάποιος να προσθέσει SQL κώδικα μέσω παραμέτρων του URL, βρήκαμε πολύ περισσότερες ευπάθειες τις οποίες και διορθώσαμε. Γενικά, παρατηρήσαμε οι πιο πολλές παράμετροι ήταν αριθμητικού τύπου και παρατηρήσαμε μάλιστα ότι σε ορισμένες σελίδες είχαν ήδη προστατευθεί μετατρέποντας το input σε ακέραια μορφή μέσω της συνάρτησης intval. Στα σημεία όπου δεν ίσχυε αυτό, την προσθέσαμε εμείς. Υπήρχαν βέβαια και κάποιες παράμετροι μη-αριθητικές. Σε αυτές επιλέξαμε να χρησιμοποιήσουμε prepare statements με την βοήθεια από τo mysqli extension. Όπως έχουμε αναφέρει και στο μάθημα, το non-executable context είναι γενικά η προτιμότερη επιλογή για άμυνα, για αυτό και το προτιμήσαμε για τις μη-αριθητικές παραμέτρους. Στις αριθμητικές περιπτώσεις, αν και η intval συνάρτηση παραπέμπει σε escaping μέθοδο, ουσιαστικά 'ακυρώνει' οποιοδήποτε executable context οπότε θεωρήσαμε ότι ήταν αρκετή.

  ### CSRF
  Για τα CSRF εστιάσαμε σε όλες τις φόρμες του site, μιας και όπως είδαμε στο μάθημα τα CSRF εκτελούνται σχεδόν αποκλειστικά μέσα από html forms. Για να εντοπίσουμε τις φόρμες που επηρεάζονταν από την επίθεση αυτή, χρησιμοποιήσαμε κάποια βοηθητικά html αρχεία όπου τοποθετήσαμε τις πιο πολλές φόρμες από το site και εκτελέσαμε την σχετική επίθεση. Γρήγορα συνειδητοποίησαμε ότι οι περισσότερες αν όχι όλες οι περισσότερες φόρμες επηρεάζονταν, για αυτό και διορθώσαμε όσες περισσότερες φόρμες βρήκαμε. Ως άμυνα για τα CSRF προσθέσαμε ένα token ως hidden input και υλοποιήσαμε και τους σχετικούς ελέγχους στην PHP. Επίσης όποιος πάει να επιτεθεί σε μια φόρμα μέσω CSRF θα ανακατευθηνθεί αυτόματα στην αρχική σελίδα του site.
  
  ### XSS
  Για τις XSS επιθέσεις εστιάσαμε σε επιθέσεις δύο είδων. Η πρώτη μορφή αφορούσε user input που ερχόταν μέσα από φόρμες και η δεύτερη για την τοποθέτηση Javascript κώδικα μέσα από παραμέτρους του URL, όπως και στα SQL injections. Γενικά και για τις δύο μορφές ως άμυνα επιλέξαμε να κάνουμε escape τους ειδικούς χαρακτήρες της HTML, έτσι ώστε να μην αποθηκεύονται στην βάση inputs που να περιέχουν scripts. Για αυτό παρέχεται η htmlspecialchars συνάρτηση από την PHP, η οποία χρησιμοποιείται και από τον έτοιμο κώδικα του open eclass ως 'q'. Γενικά σκεφτήκαμε και την άμυνα του non-executable context μέσω Content Security Policy. Διαπιστώσαμε βέβαια ότι το site χρησιμοποιεί από μόνο του πολλά inline script, οπότε για να χρησιμοποιησούμε το CSP 'ανενόχλητοι' θα έπρεπε να βάλουμε nonce σε όλα τα script που υπάρχουν ήδη το οποίο θεωρήσαμε ότι θα μας έχανε αρκετό χρόνο. Αν μπορούσαμε βέβαια να κάνουμε το site από την αρχή θα επιλέγαμε αυτήν την άμυνα, μιας και όπως έχουμε πει στο μάθημα το non-executable context είναι γενικά η προτιμότερη επιλογή. Ωστόσο σε κάποια σήμεια επιλέξαμε να το βάλουμε μιας και είδαμε ότι δεν χρησιμοποιούνται inline scripts. Να σημειώσουμε επίσης ότι σε κάποια σημεία είδαμε να γίνεται χρήση από την strip_tags της PHP (δηλαδή filtering). Αυτά τα σημεία ΔΕΝ τα τροποιήσαμε με κάποιο τρόπο. Και γενικά οποιαδήποτε άμυνα υπήρχε ήδη από το site δεν την αλλάξαμε, είτε για XSS είτε για τις άλλες επιθέσεις.
  
  ### RFI
  Στις RFI επιθέσεις, εστιάσαμε στις επιλογές που έχουν ανέβασμα αρχείου, δηλαδή στην Ανταλλαγή Αρχείων και στις Εργασίες. Παρατηρήσαμε ότι από μόνο του, το site δεν δέχεται ορισμένους τύπους αρχείων, στις Εργασίες συγκεκριμένα. Επίσης είδαμε στον κώδικα για την Ανταλλαγή Αρχείων σχολιασμένη την κλήση μιας συνάρτησης php2phps, η οποία μορφοποίει ένα php αρχείο σε ασφαλή μορφή (phps), 'εκτυπώνοντας' ουσιαστικά τον κώδικα χωρίς να μπορεί να εκτελεστεί. Επιλέξαμε να επεκτείνουμε αυτή την συνάρτηση υλοποιώντας μια αντίστοιχη λειτουργία για τα html αρχεία να μετατρέπονται σε txt. Αυτό αποτρέπει την εκτέλεση πιθανού malicious Javascript κώδικα που μπορεί να εμπεριέχεται σε ένα ανεβασμένο html αρχείο. Οπότε προσθέσαμε την updated php2phps συνάρτηση για το ανέβασμα αρχείου στην Ανταλλαγή Αρχείων και στις Εργασίες. Ως entry point για τα RFI βρήκαμε ότι στο URL της αρχικης του μαθηματος (http://localhost:8001/courses/<course_code>/) αν προσθέσει κανείς την λέξη dropbox ή work μεταφέρεται στον αντίστοιχο χώρο όπου αποθηκεύονται τα αρχεία από την Ανταλλαγή Αρχείων ή των Εργασίων. Αυτή η ευπάθεια βέβαια παρατηρήσαμε ότι εξαρτάται από τον Apache server και άρα δεν μπορούμε να την διορθώσουμε (ώστοσο δοκιμάσαμε να την διορθώσουμε με ένα .htaccess αρχείο και την εντολή Options -Indexes). Ωστόσο από την στιγμή που έχουμε φροντίσει να ανεβαίνουν σε ασφαλή μορφή τα php και html αρχεία, και να περιηγηθεί κανείς σε αυτούς τους χώρους δεν θα μπορεί να δει πιθανά επικίνδυνα αρχεία ή να τα εκτελέσει μέσα από τον browser.

- Να εξηγεί τι είδους επιθέσεις δοκιμάσατε στο αντίπαλο site και αν αυτές πέτυχαν.
