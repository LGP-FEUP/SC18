import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class CultureEntry {
  final String imagePath, title, description, location;
  final List categoryIds;

  CultureEntry(this.imagePath, this.title, this.description, this.location,
      this.categoryIds);
}

final aux1 = CultureEntry(
    "assets/aux1.png",
    "Palácio de Cristal",
    "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
    "R. de Dom Manuel II",
    [0, 1]);

final aux2 = CultureEntry("assets/logo.png", "aux2", "aux2", "aux2", [0, 2]);

final aux3 = CultureEntry("assets/logo.png", "aux3", "aux3", "aux3", [0, 3]);

final aux4 = CultureEntry("assets/logo.png", "aux4", "aux4", "aux4", [0, 4]);

final aux5 = CultureEntry("assets/logo.png", "aux5", "aux5", "aux5", [0, 5]);

final entries = [aux1, aux2, aux3, aux4, aux5];
