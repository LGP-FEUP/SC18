import 'package:erasmus_helper/models/cultureEntry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CultureDetailsBackground extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;
    final entry = Provider.of<CultureEntry>(context);

    return Align(
      alignment: Alignment.topCenter,
      child: Image.asset(
        entry.imagePath,
        fit: BoxFit.fitWidth,
        width: screenWidth,
        height: screenHeight * 0.5,
      ),
    );
  }
}

class ImageClipper extends CustomClipper<Path> {
  @override
  getClip(Size size) {
    Path path = Path();
    return path;
  }

  @override
  bool shouldReclip(covariant CustomClipper oldClipper) {
    return true;
  }
}
