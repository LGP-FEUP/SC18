import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class ForumEntry {
  final String imagePath, title, description, location;
  final List categoryIds;

  ForumEntry(this.imagePath, this.title, this.description, this.location,
      this.categoryIds);
}

final aux1 = ForumEntry("assets/logo.png", "AUX1", "AUX1", "AUX1", [0, 1]);

final aux2 = ForumEntry("assets/logo.png", "aux2", "aux2", "aux2", [0, 2]);

final aux3 = ForumEntry("assets/logo.png", "aux3", "aux3", "aux3", [0, 3]);

final aux4 = ForumEntry("assets/logo.png", "aux4", "aux4", "aux4", [0, 4]);

final aux5 = ForumEntry("assets/logo.png", "aux5", "aux5", "aux5", [0, 5]);

final entries = [aux1, aux2, aux3, aux4, aux5];
