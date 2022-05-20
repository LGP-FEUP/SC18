import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class CultureEntry {
  final String imagePath, title, description, location;
  final List categoryIds;

  CultureEntry(this.imagePath, this.title, this.description, this.location,
      this.categoryIds);
}

final aux1 = CultureEntry("1.jpg", "AUX1", "AUX1", "AUX1", [0, 1]);

final aux2 = CultureEntry(
    "../views/cultural/auxPics/1.jpg", "aux2", "aux2", "aux2", [0, 2]);

final aux3 = CultureEntry(
    "../views/cultural/auxPics/1.jpg", "aux3", "aux3", "aux3", [0, 3]);

final aux4 = CultureEntry(
    "../views/cultural/auxPics/1.jpg", "aux4", "aux4", "aux4", [0, 4]);

final aux5 = CultureEntry(
    "../views/cultural/auxPics/1.jpg", "aux5", "aux5", "aux5", [0, 5]);

final entries = [aux1, aux2, aux3, aux4, aux5];
